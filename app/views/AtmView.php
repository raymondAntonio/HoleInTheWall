<?php

require_once(dirname(__FILE__).'/../controllers/AtmController.php');

$description = "Welcome to the ATM simulation. This ATM only takes and dispenses $50 notes and/or $20 notes only." . PHP_EOL
              . "To begin with how much would you like to deposit into this ATM ?" . PHP_EOL;
echo $description;

$fiftyNoteDepositDesc = PHP_EOL. "Please Enter the number of $50 notes you wish to deposit: " . PHP_EOL;
echo $fiftyNoteDepositDesc; 
$iniFifties = AtmController::stdinReadDepositInput();

$twentyNoteDepositDesc =  "Please Enter the number of $20 notes you wish to deposit: " . PHP_EOL;
echo $twentyNoteDepositDesc;
$iniTwenties = AtmController::stdinReadDepositInput();

if(AtmController::isValid($iniFifties, $iniTwenties)) {
    $totalDeposit = ($iniFifties * 50) + ($iniTwenties * 20);
} else {
	$totalDeposit = 0;
	$iniFifties = 0;
	$iniTwenties = 0;
}

$depositsummaryDesc = "The maximum available amount in the ATM currently is $$totalDeposit which is made up of $iniFifties of $50s and $iniTwenties of $20s." . PHP_EOL;
echo $depositsummaryDesc;
$exitGreeting = PHP_EOL . "EXITING...Thank you." . PHP_EOL;
if (!$totalDeposit) {
	echo $exitGreeting;
	exit;
}

$continueAnswer = 'y';
while(strtolower($continueAnswer) === 'y') {
	// Get the withdrawn amount from the user.
	$getWithdrawnAmountDesc = PHP_EOL . "Enter the amount to be withdrawn: " . PHP_EOL;
	echo $getWithdrawnAmountDesc;
	$atmReport = AtmController::stdinReadInput($iniFifties, $iniTwenties);

	//Withdrawal amount.
	$wA       = $atmReport["wA"];
	$wA50s    = $atmReport["wA50s"];
	$wA20s    = $atmReport["wA20s"];

	// Remaining available amount.
	$rAA      = $atmReport["rAA"];
	$rAA50s   = $atmReport["rAA50s"];
	$rAA20s   = $atmReport["rAA20s"];

	// If an invalid amount entered or the ATM no longer has enough $$.
	$atmError = $atmReport["err"];
	$iniFifties = $atmReport["rAA50s"];
	$iniTwenties = $atmReport["rAA20s"];

	if ($atmError) {
		$displayerrResult = "The current ATM summary: " . PHP_EOL
		. " 1. The amount of $$wA entered can not be dispensed as this is either an invalid amount or the ATM has insufficient fund. " . PHP_EOL
		. " 2. The remaining available amount in the ATM currently is $$rAA which is made up of $rAA50s of $50s and $rAA20s of $20s . " . PHP_EOL;
		echo $displayerrResult;
	} else {
		$displayResult = "The current ATM summary: " . PHP_EOL
		. " 1. The withdrawn amount is $$wA which is made up of $wA50s of $50s and $wA20s of $20s " . PHP_EOL
		. " 2. The remaining available amount in the ATM currently after the above withdrawal is $$rAA which is made up of $rAA50s of $50s and $rAA20s of $20s . " . PHP_EOL;
		echo $displayResult;
	}
	if (!$rAA) {
		echo $exitGreeting;
		exit;
	}
	$continueQuestion = PHP_EOL . " If you wish to continue please type 'y' or any other key to exit. " . PHP_EOL;
	echo $continueQuestion;
	$continueAnswer = AtmController::stdinReadAnswer();
}

echo $exitGreeting;
