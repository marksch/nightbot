<?php

ini_set('display_errors', 0);

// the following because I always make the same mistake
function random($x) {
	return rand($x);
}

class test {

	function exists($arg) {
		if (isset($_GET["$arg"]) === TRUE) {
			return TRUE;
		} else {
			return 'error';
		}
	}

}

class parse {

	public $pi = M_PI;
	public $e = M_E;

	// pretty much every math function available in php
	function math_func_list() {
		// keeping the next line for reference
		// $arr= array("e" => "exponential number", "pi" => "the constant pi", "abs" => "Returns the absolute (positive) value of a number", "acos" => "Returns the arc cosine of a number", "acosh" => "Returns the inverse hyperbolic cosine of a number", "asin" => "Returns the arc sine of a number", "asinh" => "Returns the inverse hyperbolic sine of a number", "atan" => "Returns the arc tangent of a number in radians", "atan2" => "Returns the arc tangent of two variables x and y", "atanh" => "Returns the inverse hyperbolic tangent of a number", "base_convert" => "Converts a number from one number base to another", "bindec" => "Converts a binary number to a decimal number", "ceil" => "Rounds a number up to the nearest integer", "cos" => "Returns the cosine of a number", "cosh" => "Returns the hyperbolic cosine of a number", "decbin" => "Converts a decimal number to a binary number", "dechex" => "Converts a decimal number to a hexadecimal number", "decoct" => "Converts a decimal number to an octal number", "deg2rad" => "Converts a degree value to a radian value", "exp" => "Calculates the exponent of e", "expm1" => "Returns exp(x) - 1", "floor" => "Rounds a number down to the nearest integer", "fmod" => "Returns the remainder of x/y", "getrandmax" => "Returns the largest possible value returned by rand", "hexdec" => "Converts a hexadecimal number to a decimal number", "hypot" => "Calculates the hypotenuse of a right-angle triangle", "intdiv" => "Performs integer division", "is_finite" => "Checks whether a value is finite or not", "is_infinite" => "Checks whether a value is infinite or not", "is_nan" => "Checks whether a value is 'not-a-number'", "lcg_value" => "Returns a pseudo random number in a range between 0 and 1", "log" => "Returns the natural logarithm of a number", "log10" => "Returns the base-10 logarithm of a number", "log1p" => "Returns log(1+number)", "max" => "Returns the highest value in an array, or the highest value of several specified values", "min" => "Returns the lowest value in an array, or the lowest value of several specified values", "mt_getrandmax" => "Returns the largest possible value returned by mt_rand", "mt_rand" => "Generates a random integer using Mersenne Twister algorithm", "mt_srand" => "Seeds the Mersenne Twister random number generator", "octdec" => "Converts an octal number to a decimal number", "pi" => "Returns the value of PI", "pow" => "Returns x raised to the power of y", "rad2deg" => "Converts a radian value to a degree value", "rand" => "Generates a random integer", "round" => "Rounds a floating-point number", "sin" => "Returns the sine of a number", "sinh" => "Returns the hyperbolic sine of a number", "sqrt" => "Returns the square root of a number", "srand" => "Seeds the random number generator", "tan" => "Returns the tangent of a number", "tanh" => "Returns the hyperbolic tangent of a number");
		$arr = array('abs','acos','acosh','asin','asinh','atan','atan2','atanh','base_convert','bindec','ceil','cos','cosh','decbin','dechex','decoct','deg2rad','e','exp','expm1','floor','fmod','getrandmax','hexdec','hypot','intdiv','is_finite','is_infinite','is_nan','lcg_value','log','log10','log1p','max','min','mt_getrandmax','mt_rand','mt_srand','octdec','pi','pow','rad2deg','rand','random','round','sin','sinh','sqrt','srand','tan','tanh');
		return $arr;
	}

	function is_equation($eq) {
		return preg_match("/^[0-9a-zA-Z()\.)\,\-\+\*\^\/]+$/", $eq);
	}

	function witty_remarks() {
		$arr = array('You are a lazy bum.', 'Don\'t ask the obvious.', 'Is the sky blue?', 'Does Freckledscience have freckles?', 'Does Constababble babble?', 'Is water wet?');
		return $arr[array_rand($arr, 1)];
	}

	function get_func_list($eq) {
		// get all functions used in the equation (strings of letters and numbers) but not the symbols and the numbers
		$eq = $eq . '';
		$eq = str_replace('(', ' ', $eq);
		$eq = str_replace(')', ' ', $eq);
		// the parentheses () indicate what to replace
		$output = preg_replace(" ([0-9\-\=\/\+\*\^\,\.]+) ", ' ', $eq);
		$arr = explode(" ", $output);
		return $arr;
	}

	function is_in_func_list($x) {
		return in_array($x, $this -> math_func_list());
	}

	// relates to securetest
	function func_test($query) {
		// get all functions used in the equation
		$query_array = $this -> get_func_list($query);
		// get all functions available in php
		$mathfunclist = $this -> math_func_list($query);
		foreach ($query_array as $key => $val) {
			if ($val <> '' && $val <> ' ') {
				if (!$this -> is_in_func_list($val)) {
					return TRUE;
				}
			}
		}
		return FALSE;

	}

	function eval_equation($query, $print_equation, $fun) {
		try {
			$xtest = $this -> get_func_list($query);
			// figure out that it is a calculus problem
			if ($this -> is_equation($query)) {
				// evaluate the equation
				$query_copy = str_replace('^', '**', $query);
				$query_copy = str_replace('pi', '$pi', $query_copy);
				$query_copy = str_replace('e', '$e', $query_copy);
				eval("
				ini_set('display_errors', 0);
				
				include catch500.php;
					ini_set('disable_functions','readfile,writefile,exec,shell_exec,popen,fopen,fread,fwrite,base64_decode');
					\$pi = M_PI; 
					\$e=M_E;
					\$rslt=$query_copy;
					ini_set('disable_functions','');
				");
				// now we have the correct answer in $rslt
				if (is_numeric($rslt)) {
					if ($fun == 1) {
						// let's have some fun
						if ($rslt > -10 and $rslt < 10 and abs($rslt % 1) <= 0.0001) {
							// (almost) an integer
							$rslt = $this -> witty_remarks();
						} else if ($rslt < 0 and abs($rslt % 1) <= 0.0001) {
							$rslt = 'That\'s impossible!';
						} else {
							$diffArray = array(-1, 0, 1);
							$error = $diffArray[rand(0, 2)];
							$rslt = abs($rslt + $error);
						}
					}
					if (is_numeric($rslt) === TRUE) {
						// not a  witty remark
						if ($print_equation <> 0) {
							echo $query . ' = ' . number_format($rslt, 4);
						} else {
							echo number_format($rslt, 4);
						}
					} else {
						// witty remark
						echo $rslt;
					}

				} else {
					return FALSE;
				}
				return TRUE;

			} else {
				// return error if any
				return FALSE;
			}
		} catch (throwable $t) {
			echo $t;
			return NULL;
		}
	}

}

// q equation, p print equation, f fun
try {
	$testObj = new test;
	$tst = $testObj -> exists('q');
	if ($tst === TRUE) {
		// empty
		if ($_GET['q'] == '') {
			echo 'Type *about* or *help*.';
		}
		// check for about
		else if ($_GET['q'] == 'about') {
			echo 'Bot API by xTalkProgrammer. https://ecxtalk.nl';
		} else if ($_GET['q'] == 'help' or $_GET['q'] == '?') {
			echo <<<mark1
Bot API. | 
About: just a note | 
Help: this text | 
Allowed are: numbers, letters, and the symbols ^*/+-(). (that includes the dot). Also are allowed many functions such as log and sqrt. All system function are disable while the equation is parsed.
Are you using the 'fun' option? Keep the secret! | 
Support: buy me a coffee at https://ko-fi.com/xtalkprogrammer95395 if you like this project
mark1;
		} else {
			$parseObj = new parse;
			// security check
			$securetest = $parseObj -> func_test($_GET['q']);
			// true or false
			if ($securetest == TRUE) {
				echo 'error #3';
			} else {
				// check for fun option
				$tst = $testObj -> exists('f');
				if ($tst === true) {
					$f = $_GET['f'];
				} else {
					$f = 0;
				}
				// check option p (print equation)
				$tst = $testObj -> exists('p');
				if ($tst === TRUE) {
					$p = $_GET['p'];
				} else
					$p = 0;
				// the query exists, we can parse it
				$parseObj = new parse;
				$eval = $parseObj -> eval_equation($_GET['q'], $p, $f);
				if ($eval == TRUE) {
					// success
				} else {
					echo 'error #2';
				}
			}
		}
	} else {
		echo 'error #1';
	}
} catch (throwable $t) {
	echo $t;
	return NULL;
}
?>