<?php
/**
 *
 */
class test {

	function exists() {
		if (isset($_GET['q']))
			return 'q exists';
		else {
			return 'error';
		}
	}

}

$testObj = new test;
echo $testObj->exists();
?>