<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\Name;
use App\Console\Commands\Command;
use App\Console\Forms\User\SuperAdminForm;
use App\Commands\User\Create\CreateCommand;
use Illuminate\Contracts\Translation\Translator as Lang;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class SuperAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:superadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register super admin first time';

    public function __construct(
        protected ValidationFactory $validationFactory,
        private User $user,
        private Role $role,
        private Lang $lang,
        private SuperAdminForm $superAdminForm,
        private CommandBus $commandBus
    ) {
        parent::__construct($validationFactory);
    }

    protected function rules(): array
    {
        return $this->superAdminForm->rules();
    }

    public function handle(): void
    {
        if (!$this->superAdminForm->authorize()) {
            $this->error($this->lang->get('superadmin.exist'));

            exit;
        }

        $this->askArguments([
            'name' => $this->lang->get('auth.name.label'),
            'password_confirmation' => $this->lang->get('auth.password'),
            'password' => $this->lang->get('auth.password_confirm'),
            'email' => $this->lang->get('auth.address.label')
        ]);

        $this->commandBus->execute(new CreateCommand(
            user: $this->user,
            name: $this->argument('name'), //@phpstan-ignore-line
            email: $this->argument('email'), //@phpstan-ignore-line
            password: $this->argument('password'), //@phpstan-ignore-line
            roles: $this->role->newQuery()->whereIn(
                'name',
                [Name::SUPER_ADMIN, Name::ADMIN, Name::USER]
            )->get()
        ));

        $this->info($this->lang->get('superadmin.action.create'));
    }
}
