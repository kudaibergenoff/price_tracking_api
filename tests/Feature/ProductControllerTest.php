<?php

namespace Tests\Feature;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
	/**
	 * @param array $data
	 * @param array $resultStructure
	 * @param int $statusCode
	 * @return void
	 * @covers       \App\Http\Controllers\ProductController::create
	 * @dataProvider createDataProvider
	 */
	public function testCreate(array $data, array $resultStructure, int $statusCode): void
	{
		$this->withoutMiddleware();
		$response = $this->post("/api/product/create", $data);
		$response->assertStatus($statusCode);
		$response->assertJsonStructure($resultStructure);
	}

	public static function createDataProvider(): array
	{
		return [
			[
				'data'             => [
					'name'  => 'Тест товар',
					'price' => 1500.50
				],
				'result_structure' => [
					'success',
					'data' => [
						'id',
						'name',
						'price',
						'created_at',
						'updated_at',
					],
					'message',
				],
				'status_code'      => Response::HTTP_CREATED
			],
			[
				'data'             => [
					'price' => 1500.50
				],
				'result_structure' => [
					'message',
					'errors',
				],
				'status_code'      => Response::HTTP_UNPROCESSABLE_ENTITY
			]
		];
	}

	/**
	 * @param array $data
	 * @param array $resultStructure
	 * @param int $statusCode
	 * @return void
	 * @covers       \App\Http\Controllers\ProductController::update
	 * @dataProvider updateDataProvider
	 */
	public function testUpdate(array $data, array $resultStructure, int $statusCode): void
	{
		if ($statusCode == Response::HTTP_OK) {
			$id = Product::factory()->create()->id;
		} else {
			$id = 1000;
		}

		$this->withoutMiddleware();
		$response = $this->put("/api/product/update/$id", $data);
		$response->assertStatus($statusCode);
		$response->assertJsonStructure($resultStructure);
	}

	public static function updateDataProvider(): array
	{
		return [
			[
				'data'             => [
					'price' => 1500.50
				],
				'result_structure' => [
					'success',
					'data' => [
						'id',
						'name',
						'price',
						'created_at',
						'updated_at',
					],
					'message',
				],
				'status_code'      => Response::HTTP_OK
			],
			[
				'data'             => [
					'price' => 1500.50
				],
				'result_structure' => [
					'success',
					'data',
					'message',
				],
				'status_code'      => Response::HTTP_NOT_FOUND
			]
		];
	}

	/**
	 * @param array $resultStructure
	 * @param int $statusCode
	 * @return void
	 * @covers       \App\Http\Controllers\ProductController::delete
	 * @dataProvider deleteDataProvider
	 */
	public function testDelete(array $resultStructure, int $statusCode): void
	{
		if ($statusCode == Response::HTTP_OK) {
			$id = Product::factory()->create()->id;
		} else {
			$id = 1000;
		}

		$this->withoutMiddleware();
		$response = $this->delete("/api/product/delete/$id");
		$response->assertStatus($statusCode);
		$response->assertJsonStructure($resultStructure);
	}

	public static function deleteDataProvider(): array
	{
		return [
			[
				'result_structure' => [
					'success',
					'data',
					'message',
				],
				'status_code'      => Response::HTTP_OK
			],
			[
				'result_structure' => [
					'success',
					'data',
					'message',
				],
				'status_code'      => Response::HTTP_NOT_FOUND
			]
		];
	}

	/**
	 * @return void
	 * @covers \App\Http\Controllers\ProductController::getList
	 */
	public function testGetList(): void
	{
		$this->withoutMiddleware();
		$response = $this->get('/api/product/list');
		$response->assertStatus(Response::HTTP_OK);
		$response->assertJsonStructure([
			'success',
			'data' => [
				'*' => [
					'id',
					'name',
					'price',
					'created_at',
					'updated_at',
				]
			],
			'message',
		]);
	}
}