<?php

namespace App\Http\Controllers;

use App\Domain\Services\ProductServiceInterface;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private ProductServiceInterface $service;

    public function __construct(ProductServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post (
     ** path="/api/product/create",
     *   tags={"Товар"},
     *   summary="Создать Товар",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="price",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
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
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function create(CreateProductRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->service->create($request->validated()),
            Response::HTTP_CREATED,
            'Товар успешно создан'
        );
    }

    /**
     * @OA\Put (
     ** path="/api/product/update/{product_id}",
     *   tags={"Товар"},
     *   summary="Обновить Товар",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="product_id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="price",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Успешно"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Ошибка проверки"
     *   )
     *)
     *
     * @param int $id
     * @param UpdateProductRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProductRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->service->update($id, $request->validated()),
            Response::HTTP_OK,
            'Товар успешно обновлен'
        );
    }

    /**
     * @OA\Delete (
     ** path="/api/product/delete/{product_id}",
     *   tags={"Товар"},
     *   summary="Удалить Товар",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="product_id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Успешно"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Ошибка проверки"
     *   )
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
            'Товар успешно удален'
        );
    }

    /**
     * @OA\Get (
     ** path="/api/product/list",
     *   tags={"Товар"},
     *   summary="Список Товаров",
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
        return $this->successResponse($this->service->getList());
    }
}
