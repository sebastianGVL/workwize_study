<?php

namespace App\Modules\Storefront\Customer\Interface\Http\Controllers;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use App\Modules\Storefront\Customer\Application\Data\LoginData;
use App\Modules\Storefront\Customer\Application\Data\RegistrationData;
use App\Modules\Storefront\Customer\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractRegisterRequest;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Customer\Domain\Services\AuthServiceInterface;
use App\Modules\Storefront\Customer\Domain\Services\RegistrationServiceInterface;
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
        $customer = $this->registrationService->register(RegistrationData::fromRequest($request));

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'customer' => [
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'token' => $customer->createToken('token_' . $customer->email, ['customer'])->plainTextToken,
                    ],
                ],
                'success'
            ),
            status: Response::HTTP_CREATED
        );
    }

    public function login(AbstractLoginRequest $request): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $this->authService->login(LoginData::fromRequest($request));

        if (is_null($customer)) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'Invalid credentials')->toArray(),
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'user' => [
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'token' => $customer->createToken('token_' . $customer->email, ['customer'])->plainTextToken,
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
