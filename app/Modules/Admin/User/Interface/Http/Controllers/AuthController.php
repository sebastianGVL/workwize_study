<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Interface\Http\Controllers;

use App\Modules\Admin\User\Application\Data\LoginData;
use App\Modules\Admin\User\Application\Data\RegistrationData;
use App\Modules\Admin\User\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Admin\User\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Admin\User\Domain\Http\Requests\AbstractRegisterRequest;
use App\Modules\Admin\User\Domain\Models\User;
use App\Modules\Admin\User\Domain\Services\AuthServiceInterface;
use App\Modules\Admin\User\Domain\Services\RegistrationServiceInterface;
use App\Modules\Admin\User\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractAuthController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly RegistrationServiceInterface $registrationService,
    )
    {
    }

    public function register(AbstractRegisterRequest $request): JsonResponse
    {
        $user = $this->registrationService->register(RegistrationData::fromRequest($request));

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'token' => $user->createToken('token_' . $user->email)->plainTextToken,
                    ],
                ],
                'success'
            ),
            status: Response::HTTP_CREATED
        );
    }

    public function login(AbstractLoginRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->authService->login(LoginData::fromRequest($request));

        if (is_null($user)) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'Invalid credentials')->toArray(),
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'token' => $user->createToken('token_' . $user->email)->plainTextToken,
                    ],
                ],
                'succcess'
            ),
            status: Response::HTTP_OK,
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(
            data: BaseApiResponseData::make(null, 'success'),
            status: Response::HTTP_NO_CONTENT
        );
    }
}
