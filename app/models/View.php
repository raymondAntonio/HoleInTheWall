<?php

class View {

	public static function stdinReadDepositInput() {
		// Open the file pointer to read from stdin.
		$fr=fopen("php://stdin","r");
		while($input = fscanf(STDIN, "%d\n")) {
			$depositInput = $input[0] != NULL ? $input[0] : 0;
			fclose ($fr); // Close file handle.
			return $depositInput;
		};
	}

	public static function stdinReadInput($iniFifties, $iniTwenties) {
		$atmReport = array();
		// Open the file pointer to read from stdin.
		$fr=fopen("php://stdin","r");
		while($input = fscanf(STDIN, "%d\n")) {
			$atmController = new AtmController;
			$atmReport = $atmController->forwardAndRetrieve($input[0], $iniFifties, $iniTwenties);
			fclose ($fr); // Close file handle.
			return $atmReport;
		};
	
	}

	public static function stdinReadAnswer() {
		$fr=fopen("php://stdin","r");
		$answer = fgets($fr);
		$answer = rtrim($answer);
		fclose ($fr);
		return $answer;
	}
}