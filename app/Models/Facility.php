<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
	use SoftDeletes;
	public const CATEGORY_META = [
		'fasilitas-utama' => [
			'label' => 'Fasilitas Utama',
			'icon' => 'fa-school',
			'description' => 'Ruang kelas, kantor layanan akademik, dan area penerima tamu.',
		],
		'laboratorium' => [
			'label' => 'Laboratorium & Inovasi',
			'icon' => 'fa-flask',
			'description' => 'Laboratorium sains, komputer, dan ruang praktik eksperimen.',
		],
		'perpustakaan' => [
			'label' => 'Perpustakaan & Literasi',
			'icon' => 'fa-book-open',
			'description' => 'Ruang baca, pojok literasi digital, dan layanan referensi.',
		],
		'penunjang' => [
			'label' => 'Fasilitas Penunjang',
			'icon' => 'fa-layer-group',
			'description' => 'Aula, UKS, gudang sarpras, dan ruang serbaguna lainnya.',
		],
		'lingkungan' => [
			'label' => 'Kawasan Lingkungan',
			'icon' => 'fa-tree',
			'description' => 'Lapangan, taman Adiwiyata, greenhouse, dan fasilitas luar ruang.',
		],
	];

	public const CONDITION_META = [
		'baik' => ['label' => 'Layak Pakai', 'badge' => 'success'],
		'cukup' => ['label' => 'Perlu Penyesuaian', 'badge' => 'warning'],
		'perlu_perbaikan' => ['label' => 'Perlu Perbaikan', 'badge' => 'danger'],
	];

	protected $fillable = [
		'nama',
		'kategori',
		'deskripsi',
		'jumlah',
		'kondisi',
		'foto_path',
		'status_publish',
	];

	protected $casts = [
		'jumlah' => 'integer',
		'status_publish' => 'boolean',
	];

	public static function categoryOptions(): array
	{
		return collect(self::CATEGORY_META)
			->map(fn ($meta) => $meta['label'])
			->toArray();
	}

	public static function categoryMeta(): array
	{
		return self::CATEGORY_META;
	}

	public static function conditionOptions(): array
	{
		return collect(self::CONDITION_META)
			->map(fn ($meta) => $meta['label'])
			->toArray();
	}

	public static function conditionMeta(): array
	{
		return self::CONDITION_META;
	}

	public function scopePublished(Builder $query): Builder
	{
		return $query->where('status_publish', true);
	}

	public function getPhotoUrlAttribute(): ?string
	{
		if ($this->foto_path) {
			$cleanPath = ltrim(preg_replace('/^(storage\/|media\/)+/', '', $this->foto_path), '/');
			return url('media/' . $cleanPath);
		}

		return null;
	}
}
