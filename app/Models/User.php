<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

	protected $fillable = [
		'first_name',
		'middle_name',
		'last_name',
		'birthdate',
		'email',
		'avatar',
		'username',
		'password',
		'login_attempts',
		'locked',
		'locked_by',
		'last_auth'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'birthdate' => 'date: M d, y',
		'last_auth' => 'date: M d, y',
		'created_at' => 'date: M d, y',
		'updated_at' => 'date: M d, y',
		'deleted_at' => 'date: M d, y',
	];

	// Custom Function
	public function getAvatar($useDefault=false, $getFull=true) {
		$avatar = $this->avatar;
		$avatarF = $avatar == null ? 'default.png' : $avatar;
		$avatarU = asset("storage/uploads/users/{$avatar}");
		$avatarD = asset('storage/uploads/users/default.png');
		$toRet = null;

		if ($useDefault) {
			if ($getFull)
				return $avatarD;
			else
				return 'default.png';
		}
		else {
			if ($getFull) {
				if ($this->is_avatar_link)
					$toRet = $avatarF;
				else
					$toRet = $avatarU;
			}
			else {
				$toRet = $avatarF;
			}
		}

		return $toRet;
	}

	public function getName($include_middle = false) {
		return $this->first_name . ($include_middle ? (' ' . $this->middle_name . ' ') : ' ') . $this->last_name;
	}

	// Static Functions
	public static function getIP() {
		$ip = request()->ip();

		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];

		return $ip;
	}
}
