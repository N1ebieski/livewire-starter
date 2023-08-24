<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\Console\Commands\Command;
use App\Console\Forms\User\SuperAdminForm;
use App\Commands\User\Create\CreateCommand;
use Illuminate\Contracts\Translation\Translator as Lang;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\error;
use function Laravel\Prompts\password;

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
            error($this->lang->get('superadmin.exist'));

            exit;
        }

        $name = text(
            label: $this->lang->get('auth.name.label'),
            default: 'admin',
            validate: fn (string $value) => $this->validateOnly('name', $value)
        );

        $password = password(
            label: $this->lang->get('auth.password'),
            validate: fn (string $value) => $this->validateOnly('password', $value)
        );

        $email = text(
            label: $this->lang->get('auth.address.label'),
            validate: fn (string $value) => $this->validateOnly('email', $value)
        );

        $this->commandBus->execute(new CreateCommand(
            user: $this->user,
            name: $name,
            email: $email,
            password: $password,
            roles: $this->role->all()
        ));

        info($this->lang->get('superadmin.action.create'));
    }
}
