<?php

require_once(dirname(__FILE__).'/../models/Machine.php');
require_once(dirname(__FILE__).'/../models/View.php');

class AtmController {

	/**
	 * forward the user input to the model and retrieve the result to be sent back to the
	 * view
	 * @return array $atmReport
	 */
	public function forwardAndRetrieve($withdrawnAmount, $iniFifties, $iniTwenties) { 
		$atmReport = array();
		$nextMachine = new Machine($withdrawnAmount, $iniFifties, $iniTwenties);
		$atmReport = $nextMachine->getReport();
		return $atmReport;
	}

	public static function isValid($fifties, $twenties) {
		return Machine::isValid($fifties, $twenties);
	}

	public static function stdinReadDepositInput() {
		return View::stdinReadDepositInput();
	}

	public static function stdinReadInput($iniFifties, $iniTwenties) {
		return View::stdinReadInput($iniFifties, $iniTwenties);
	}

	public static function stdinReadAnswer() {
		return View::stdinReadAnswer();
	}
}