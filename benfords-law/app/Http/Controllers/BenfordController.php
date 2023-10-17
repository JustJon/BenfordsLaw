<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class BenfordController extends Controller
{
	public function process(request $request):View {
		$request->numberList = explode(',', $request->numbers);
    		$validated = $request->validate([
        		'numbers' => 'required|min:1',
    		]);

		$numbers = explode(',', $request->numbers);
		$validator = \Validator::make(compact('numbers'), [
    			'numbers' => 'required|array',
    			'numbers.*' => 'integer'
		], [
			'numbers.integer' => 'All values must be integers'
		]);
		$this->validateWith($validator);
		$response = $this->benford($request->numberList);

		return view('benford')->with('response', $response);
	}


	private function benford($numbers) {

		$hist = [];

		$total = count($numbers);
                foreach ($numbers as $number) {
                        $number = trim($number);
                        $first = $number[0];
			if (!isset($hist[$first])) {
				$hist[$first] = 0;
			}
			$hist[$first]++;
                }

		//This variable counts all the digits for acceptable values
		//It must be 9 to be considered proving the law
		$acceptableValues = 0;

		for ($i=1; $i<10; $i++) {
			//For flexibity on the histogram, we are giving the Benford's Law 
			//Percentages a couple percentage points flexibility rather than
			//using the exact decimal values of the Law
			if (isset($hist[$i])) {
				$percentage = $hist[$i]/$total;
			}
			switch ($i) {

				case 1:
					if ($percentage > 28 && $percentage > 32) {
						$acceptableValues++;
					}
					break;	
				case 2:
					if ($percentage > 15 && $percentage > 19) {
						$acceptableValues++;
					}
					break;	
				case 3:
					if ($percentage > 10 && $percentage > 14) {
						$acceptableValues++;
					}
					break;	
				case 4:
					if ($percentage > 7 && $percentage > 11) {
						$acceptableValues++;
					}
					break;	
				case 5:
					if ($percentage > 5  && $percentage > 10) {
						$acceptableValues++;
					}
					break;	
				case 6:
					if ($percentage > 4 && $percentage > 9) {
						$acceptableValues++;
					}
					break;	
				case 7:
					if ($percentage > 3 && $percentage > 8) {
						$acceptableValues++;
					}
					break;	
				case 8:
					if ($percentage > 2 && $percentage > 7) {
						$acceptableValues++;
					}
					break;	
				case 9:
					if ($percentage > 1 && $percentage > 6) {
						$acceptableValues++;
					}
					break;	
				default:
					break;
			} 

			
		}

		if ($acceptableValues == 9) {
			$response = "The numbers meet Benford's Law";
		} else {
			$response = "The numbers do not meet Benford's Law";

		}

		return $response;
	}
}
