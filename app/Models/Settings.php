<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'value',
		'is_file'
	];

	// CUSTOM FUNCTIONS
	public static function getInstance($key = null) {
		if ($key == null)
			return Settings::get();
		return Settings::where('name', '=', $key)->first();
	}

	public static function getValue($key) {
		$setting = Settings::where('name', '=', $key)->first();

		if ($setting == null)
			return null;
		return $setting->value;
	}

	public static function getFile($key) {
		$setting = Settings::where('name', '=', $key)->first();

		if ($setting->is_file)
			return asset('storage/uploads/settings/' . $setting->value);
		return $setting->value;
	}

	public function getImage($useDefault=false, $getFull=true) {
		$value = $this->value;
		$settingF = $value == null ? 'default.png' : $value;
		$settingU = asset("storage/uploads/settings/{$settingF}");
		$settingD = asset('storage/uploads/settings/default.png');
		$toRet = null;

		if ($useDefault) {
			if ($getFull)
				return $settingD;
			else
				return 'default.png';
		}
		else {
			if ($getFull) {
				if (!$this->is_file)
					$toRet = $settingF;
				else
					$toRet = $settingU;
			}
			else {
				$toRet = $settingF;
			}
		}

		return $toRet;
	}
}