<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
	use HasFactory;

	public static function getClient(): Model
	{
		return self::query()
			->where('password_client', '=', true)
			->where('revoked', '=', false)
			->where('provider', '=', 'users')
			->orderByDesc('created_at')
			->first();
	}
}
