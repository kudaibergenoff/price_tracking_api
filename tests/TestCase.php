<?php

namespace Tests;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, DatabaseTransactions;

	protected User $user;

	protected function setUp(): void
	{
		parent::setUp();
		$this->user = User::factory()->create();
	}

	protected function getLogin(): array
	{
		$serverRequest = app(ServerRequestInterface::class);
		$param         = $serverRequest->withParsedBody([
			'email'    => $this->user->email,
			'password' => 'password',
		]);
		$login         = app(AuthController::class)->login($param);

		return json_decode($login->getContent(), true)['data'];
	}
}
