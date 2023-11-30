<?php

namespace App\Http\Controllers;

use App\Domain\Services\UserProductServiceInterface;
use App\Http\Requests\CreateUserProductRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserProductController extends Controller
{
    private UserProductServiceInterface $service;

    public function __construct(UserProductServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post (
     ** path="/api/user-products/create",
     *   tags={"Подписка на товар"},
     *   summary="Подписаться на товар",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="product_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Успешно"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Ошибка проверки"
     *   )
     *)
     *
     * @param CreateUserProductRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserProductRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->service->create($request->validated()),
            Response::HTTP_CREATED,
            'Пользователь успешно подписан на товар'
        );
    }

    /**
     * @OA\Delete (
     ** path="/api/user-products/delete/{user_product_id}",
     *   tags={"Подписка на товар"},
     *   summary="Отписка от товара",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="user_product_id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    @OA\Response(
     *       response=200,
     *        description="Успешно"
     *    ),
     *    @OA\Response(
     *       response=422,
     *       description="Ошибка проверки"
     *    )
     *)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->successResponse(
            $this->service->delete($id),
            Response::HTTP_OK,
            'Пользователь успешно отписался от товара'
        );
    }

    /**
     * @OA\Get (
     ** path="/api/user-products/list",
     *   tags={"Подписка на товар"},
     *   summary="Список подписанных товаров",
     *   security={ {"bearer": {} }},
     *   @OA\Response(
     *      response=200,
     *       description="Успешно"
     *   )
     *)
     *
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        return $this->successResponse($this->service->getUserProducts());
    }
}
