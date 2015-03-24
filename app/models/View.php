<?php

class View {

	public static function stdinReadfiftiesDepositInput() {
		// Open the file pointer to read from stdin.
		$fr=fopen("php://stdin","r");
		while($input = fscanf(STDIN, "%d\n")) {
			$fifties = $input[0] != NULL ? $input[0] : 0;
			fclose ($fr); // Close file handle.
			return $fifties;
		};
	}

	public static function stdinReadTwentyDepositInput() {
		// Open the file pointer to read from stdin.
		$fr=fopen("php://stdin","r");
		while($input = fscanf(STDIN, "%d\n")) {
			$twenties = $input[0] != NULL ? $input[0] : 0;
			fclose ($fr); // Close file handle.
			return $twenties;
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