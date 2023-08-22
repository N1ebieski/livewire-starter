<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\User\Status;
use App\Http\Controllers\Controller;
use App\ValueObjects\User\Marketing;
use App\Providers\RouteServiceProvider;
use App\Commands\User\Create\CreateCommand;
use App\View\Metas\Auth\RegisterMetaFactory;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Auth\Register\RegisterRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(
        private User $user,
        private RegisterMetaFactory $metaFactory,
        private ResponseFactory $responseFactory,
        private ValidationFactory $validationFactory,
        private CommandBus $commandBus
    ) {
        $this->middleware('guest');
    }

    public function showRegistrationForm(): HttpResponse
    {
        $meta = $this->metaFactory->make();

        return $this->responseFactory->view('auth.register', compact('meta'));
    }

    protected function validator(array $data): Validator
    {
        $registerRequest = new RegisterRequest();

        return $this->validationFactory->make($data, $registerRequest->rules());
    }

    protected function create(array $data): User
    {
        /** @var User */
        $user = $this->commandBus->execute(new CreateCommand(
            user: $this->user,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        ));

        return $user;
    }
}
