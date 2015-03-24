<?php 

require_once(dirname(__FILE__).'/../../vendor/autoload.php');
require_once(dirname(__FILE__).'/../models/Machine.php');

class AtmMachineTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider testIsValidData
	 */
	public function testIsValid($iniFifties, $iniTwenties, $expected) {
		$machine = new Machine(0, $iniFifties, $iniTwenties);
		$actualResultIV = $machine::isValid($iniFifties, $iniTwenties);

		$this->assertNotTrue($actualResultIV);
		$this->assertNotTrue($actualResultIV);
		$this->assertNotTrue($actualResultIV);
		$this->assertNotTrue($actualResultIV);
	}

	public function testIsValidData() {
		return array(
				//negative fifties
				array(-2, 15, false),
				// negative twenties
				array(2, -15, false),
				// both negatives
				array(-2, -15, false),
 				//String or char
				array("string$%#$", "S", false)
		);
	}

	/**
	 * @dataProvider testWithdrawalNoteTokenizerData
	 */
	public function testWithdrawalNoteTokenizer($withdrawalAmount, $iniFifties, $iniTwenties, $expected) {
		$actualResultIWSWNT = array();

		$machine = new Machine($withdrawalAmount, $iniFifties, $iniTwenties);
		// Testing to tokenise the Withdrawal.
		$actualResultIWSWNT = $machine->withdrawalNoteTokenizer();
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);
		$this->assertEquals($expected[0], $actualResultIWSWNT[0]);
		$this->assertEquals($expected[1], $actualResultIWSWNT[1]);

		return $actualResultIWSWNT;
	}

	public function testWithdrawalNoteTokenizerData() {
		return array(
				//negative
				array(-20, 6,15, array(0, 0)),
				// Under the min
				array(10, 10, 10, array(0, 0)),
				// normal
				array(40, 2, 2, array(0, 2)),
				// bigger normal + tricky combo %50 =0
				array(550, 6, 15, array(5, 15)),
				// bigger normal + tricky combo %20 =0
				array(560, 6, 15, array(6, 13)),
				// slightly tricky 
				// bigger normal + tricky combo
				array(290, 5, 5, array(5, 2)),
				// slightly tricky
				array(130, 5, 5, array(1, 4)),
				// slightly trickier
				array(600, 6, 16, array(6, 15)),
				// Odd
				array(265, 10, 15, array(0, 0)),
				// float
				array(360.666, 15, 15, array(0, 0)),
				//pretty big num that can slow down PHPunit processing the data
				array(130000000,2700000, 25, array(2600000, 0)),
				// String and char
				array("string$%#$", 200, 250, array(0, 0))
		);
 	}

 	/**
 	 * @dataProvider testIsWithdrawalSuccessfulData
 	 * @depends testWithdrawalNoteTokenizer
 	 */
 	public function testIsWithdrawalSuccessful($actualResultIWSWNT, $withdrawalAmount, $expected) {
 	
 		$machine = new Machine($withdrawalAmount);
 		$actualResultIWS = $machine->isWithdrawalSuccessful($actualResultIWSWNT);
 		$this->assertEquals($expected, $actualResultIWS[0]);
 		$this->assertEquals($expected, $actualResultIWS[1]);
 		$this->assertEquals($expected, $actualResultIWS[0]);
 		$this->assertEquals($expected, $actualResultIWS[1]);
 		$this->assertEquals($expected, $actualResultIWS[0]);
 		$this->assertEquals($expected, $actualResultIWS[1]);
 	
 		return $actualResultIWS;
 	}
 	
 	public function testIsWithdrawalSuccessfulData() {
 		return array(
 				array(-20, false),
 				array(10, false),
 				array(40, true),
 				array(100, true),
 				array(130, true),
 				array(265, false),
 				array(360.666, false),
 				array(130000000, true),
 				array("string$%#$", false)
 		);
 	}


 	/**
 	 * @dataProvider testgetReportData
 	 * @depends testWithdrawalNoteTokenizer
 	 * @depends testIsWithdrawalSuccessfulData
 	 * @depends testWithdrawalNoteTokenizer
 	 */
 	public function testgetReport($withdrawalAmount, $iniFifties, $iniTwenties, $expected) {
 		$machine = new Machine($withdrawalAmount, $iniFifties, $iniTwenties);
 		$actualResultGR = $machine->getReport();

 		$this->assertEquals($expected["wA"], $actualResultGR["wA"]);
 		$this->assertEquals($expected["wA50s"], $actualResultGR["wA50s"]);
 		$this->assertEquals($expected["wA20s"], $actualResultGR["wA20s"]);
 		$this->assertEquals($expected["rAA"], $actualResultGR["rAA"]);
 		$this->assertEquals($expected["rAA50s"], $actualResultGR["rAA50s"]);
 		$this->assertEquals($expected["rAA20s"], $actualResultGR["rAA20s"]);
 		$this->assertEquals($expected["err"], $actualResultGR["err"]);

 		$this->assertEquals($expected["wA"], $actualResultGR["wA"]);
 		$this->assertEquals($expected["wA50s"], $actualResultGR["wA50s"]);
 		$this->assertEquals($expected["wA20s"], $actualResultGR["wA20s"]);
 		$this->assertEquals($expected["rAA"], $actualResultGR["rAA"]);
 		$this->assertEquals($expected["rAA50s"], $actualResultGR["rAA50s"]);
 		$this->assertEquals($expected["rAA20s"], $actualResultGR["rAA20s"]);
 		$this->assertEquals($expected["err"], $actualResultGR["err"]);

 		$this->assertEquals($expected["wA"], $actualResultGR["wA"]);
 		$this->assertEquals($expected["wA50s"], $actualResultGR["wA50s"]);
 		$this->assertEquals($expected["wA20s"], $actualResultGR["wA20s"]);
 		$this->assertEquals($expected["rAA"], $actualResultGR["rAA"]);
 		$this->assertEquals($expected["rAA50s"], $actualResultGR["rAA50s"]);
 		$this->assertEquals($expected["rAA20s"], $actualResultGR["rAA20s"]);
 		$this->assertEquals($expected["err"], $actualResultGR["err"]);
 	}

 	public function testgetReportData() {
 		return array(
 				array(10, 10, 10, array("wA" => 10, "wA50s" => 0, "wA20s" => 0, "rAA" => 700, "rAA50s" => 10, "rAA20s" => 10, "err" => true)),
 				array(20, 10, 10, array("wA" => 20, "wA50s" => 0, "wA20s" => 1, "rAA" => 680, "rAA50s" => 10, "rAA20s" => 9, "err" => false)),
 				array(70, 2, 2, array("wA" => 70, "wA50s" => 1, "wA20s" => 1, "rAA" => 70, "rAA50s" => 1, "rAA20s" => 1, "err" => false))
 		);
 	}

}
