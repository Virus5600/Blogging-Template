<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Carousel;

use DB;
use Exception;
use Log;
use Validator;

class APIController extends Controller
{
	protected function fetchCarousel(Request $req) {
		$carousel = Carousel::select(['image', 'description'])
			->take(5)
			->get();

		return response()
			->json([
				'content' => $carousel
			]);
	}
}