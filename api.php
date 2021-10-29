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

	function is_equation($eq) {
		return preg_match("/^[0-9a-zA-Z()\.)\-\+\*\^\/]+$/", $eq);
	}

	function witty_remarks() {
		$arr = array('You are a lazy bum.', 'Don\'t ask the obvious.', 'Is the sky blue?', 'Does Freckledscience have freckles?');
		return $arr[array_rand($arr, 1)];
	}

	function eval_equation($query, $print_equation, $fun) {
		try {
			// figure out that it is a calculus problem
			if ($this -> is_equation($query)) {
				// evaluate the equation
				$query_copy = str_replace('^', '**', $query);
				$query_copy = str_replace('pi', '$pi', $query_copy);
				$query_copy = str_replace('e', '$e', $query_copy);
				// echo number_format($e,4);
				eval("
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
						if ($rslt < 10 and abs($rslt % 1) <= 0.0001) {
							$rslt = $this -> witty_remarks();
						} else {
							$diffArray = array(-1, 0, 1);
							$error = $diffArray[rand(0, 2)];
							$rslt = abs($rslt + $error);
						}
					}
					if (is_numeric($rslt)===TRUE) {
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
			return NULL;
		}
	}

}

// q equation, p print equation, f fun

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
} else {
	echo 'error #1';
}
?>