<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
	protected $guarded = [];

	protected $casts = [
		'struktur_guru' => 'array',
		'struktur_tu' => 'array',
	];
}
