<?php

namespace App\Http\Controllers;

use App\Domain\Services\UserServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Models\OauthClient;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AccessTokenController
{
    use ApiResponse;

    private UserServiceInterface $userService;

    public function __construct(
        AuthorizationServer  $authorizationServer,
        TokenRepository      $tokenRepository,
        UserServiceInterface $userService
    )
    {
        parent::__construct($authorizationServer, $tokenRepository);
        $this->userService = $userService;
    }

    /**
     * @OA\Post (
     ** path="/api/user/register",
     *   tags={"Авторизация"},
     *   summary="Вход",
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Успешно",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="success", type="boolean", example="true"),
     *          @OA\Property(property="message", type="string", example="Пользователь успешно зарегистрирован"),
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Ошибка проверки"
     *   )
     *)
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return $this->successResponse(
            $user,
            Response::HTTP_CREATED,
            'Пользователь успешно зарегистрирован'
        );
    }

    /**
     * @OA\Post (
     *     path="/api/user/login",
     *     summary = "Логин",
     *     tags={"Авторизация"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="email",
     *             description="Email",
     *             type="string",
     *             example="test@test.com",
     *           ),
     *          @OA\Property(
     *             property="password",
     *             description="Password",
     *             type="string",
     *             example="admin",
     *           ),
     *         ),
     *       ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Пользовтель не найден",
     *      ),
     *     @OA\Response(
     *         response="401",
     *         description="Не авторизован",
     *     )
     * )
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function login(ServerRequestInterface $request): JsonResponse
    {
        $inputParams = $request->getParsedBody();
        $inputEmail = $inputParams['email'];
        $inputPassword = $inputParams['password'];
        $user = $this->userService->get(['email' => $inputEmail]);

        if (!Hash::check($inputPassword, $user->password)) {
            return $this->errorResponse(
                null,
                Response::HTTP_UNAUTHORIZED,
                'Недействительные учетные данные'
            );
        }

		$client = OauthClient::getClient();
        $request = $request->withParsedBody([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $inputEmail,
            'password' => $inputPassword,
            'scope' => '*',
        ]);

        return $this->successResponse(
            json_decode($this->issueToken($request)->getContent(), true),
            Response::HTTP_OK,
            'Вы вошли'
        );

    }

    /**
     * @OA\Post (
     *     path="/api/user/logout",
     *     summary = "Выход",
     *     tags={"Авторизация"},
     *     security={ {"bearer": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *     )
     * )
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $token = $request->user('api')->token();

        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        $token->revoke();

        return $this->successResponse(null, Response::HTTP_OK, 'Успешный выход из системы');
    }

    /**
     * @OA\Post (
     *     path="/api/user/refresh-token",
     *     summary = "Рефреш",
     *     tags={"Авторизация"},
     *     @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="refresh_token",
     *             description="Refresh Token",
     *             type="string",
     *           ),
     *         ),
     *       ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *     )
     * )
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function refresh(ServerRequestInterface $request): JsonResponse
    {
		$client = OauthClient::getClient();
        $request = $request->withParsedBody([
            'grant_type' => 'refresh_token',
			'client_id' => $client->id,
			'client_secret' => $client->secret,
            'refresh_token' => request()->refresh_token,
            'scope' => '*',
        ]);

        return $this->successResponse(
            json_decode($this->issueToken($request)->getContent(), true)
        );
    }
}
