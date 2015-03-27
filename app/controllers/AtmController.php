<?php

require_once(dirname(__FILE__).'/../../AutoloadBootstrap.php');

class AtmController {

	public static function stdinReadDepositInput() {
		return View::stdinReadDepositInput();
	}

	public static function stdinReadInput($iniFifties, $iniTwenties) {
		return View::stdinReadInput($iniFifties, $iniTwenties);
	}

	public static function stdinReadAnswer() {
		return View::stdinReadAnswer();
	}

	public static function isValid($fifties, $twenties) {
		return Machine::isValid($fifties, $twenties);
	}
}