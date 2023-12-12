<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\Console\Commands\Handler;
use App\Console\Forms\User\SuperAdminForm;
use App\Commands\User\Create\CreateCommand;
use Illuminate\Contracts\Translation\Translator;
use App\Extends\Laravel\Prompts\Contracts\Prompts;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

final class SuperAdminHandler extends Handler
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
        ValidationFactory $validationFactory,
private Prompts $prompts,
        private User $user,
        private Role $role,
        private Translator $translator,
        private CommandBus $commandBus,
        protected SuperAdminForm $form,
    ) {
        parent::__construct($validationFactory);
    }

    public function handle(): void
    {
        if (!$this->form->authorize()) {
            $this->prompts->error($this->translator->get('superadmin.exist'));

            exit;
        }

        $name = $this->prompts->text(
            label: $this->translator->get('auth.name.label'),
            default: 'admin',
            validate: fn (string $value) => $this->validateOnly('name', $value)
        );

        $password = $this->prompts->password(
            label: $this->translator->get('auth.password'),
            validate: fn (string $value) => $this->validateOnly('password', $value)
        );

        $email = $this->prompts->text(
            label: $this->translator->get('auth.address.label'),
            validate: fn (string $value) => $this->validateOnly('email', $value)
        );

        $this->commandBus->execute(new CreateCommand(
            user: $this->user,
            name: $name,
            email: $email,
            password: $password,
            roles: $this->role->all()
        ));

        $this->prompts->info($this->translator->get('superadmin.messages.create'));
    }
}
