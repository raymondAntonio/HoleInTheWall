<?php
//namespace machine;
//use models\Atm as Atm;

require_once('Atm.php');
define("FIFTY", 50);
define("TWENTY", 20);
class Machine implements Atm {

	private $withdrawalEntry;
	private $depositFifties;
	private $depositTwenties;
	private $maxAvailAmount;
	private $atmReport = array();

    /**
     * 
     * @param number $withdrawalEntry
     * @param number $iniFifties
     * @param number $iniTwenties
     * 
     */
	public function __construct($withdrawalEntry = 0, $iniFifties = 0, $iniTwenties = 0) {
		$this->withdrawalEntry = $withdrawalEntry;
		$this->depositFifties = $iniFifties;
		$this->depositTwenties = $iniTwenties;
		$this->maxAvailAmount = ($this->depositFifties * FIFTY) + ($this->depositTwenties * TWENTY);
	}

	public static function isValid($fifties, $twenties) {
		return ($fifties > 0) && ($twenties > 0);
	}

    /**
     * 
     * @return array
     */
	public function withdrawalNoteTokenizer() {
		$twentyNotes = 0;
		$fiftyNotes = 0;
		$withdrawalValidation = $this->withdrawalEntry > 0 && is_int($this->withdrawalEntry) && ($this->withdrawalEntry % 2 == 0);
		$withdrawal = $withdrawalValidation ? $this->withdrawalEntry : 0;
		$wid50sIf = $withdrawal / FIFTY;
		$wid20sIf = $withdrawal / TWENTY;
		$dep50s = $this->depositFifties;
		$dep20s = $this->depositTwenties;

		if ($withdrawal == $this->maxAvailAmount) {
			$twentyNotes = $this->depositTwenties;
			$fiftyNotes = $this->depositFifties;
			return array (
					$fiftyNotes,
					$twentyNotes 
			);
		}

		if ($withdrawal % FIFTY == 0) {
			if ($dep50s >= $wid50sIf) {
				$fiftyNotes = $wid50sIf;
			} else {
				$dep50sSum = $dep50s * FIFTY;
				do {
					$twentyNotes += 1;
					$dep20s -= 1;
					$withdrawal = $withdrawal - TWENTY;
					while (($withdrawal % FIFTY != 0) && ($dep20s > 0)) {
						$twentyNotes += 1;
						$dep20s -= 1;
						$withdrawal = $withdrawal - TWENTY;
					}
				} while ($withdrawal > $dep50sSum);
				while ( $withdrawal > 0 ) {
					$fiftyNotes += 1;
					$dep50s -= 1;
					$withdrawal = $withdrawal - FIFTY;
				}
			}
		} else if ($withdrawal % TWENTY == 0) {
			if ($dep20s >= $wid20sIf) {
				$twentyNotes = $wid20sIf;
			} else {
				$dep20sSum = $dep20s * TWENTY;
				do {
					$fiftyNotes += 1;
					$dep50s -= 1;
					$withdrawal = $withdrawal - FIFTY;
					while (($withdrawal % TWENTY != 0) && ($dep50s > 0)) {
						$fiftyNotes += 1;
						$dep50s -= 1;
						$withdrawal = $withdrawal - FIFTY;
					}
				} while ($withdrawal > $dep20sSum);
				
				while ($withdrawal > 0) {
					$twentyNotes += 1;
					$dep20s -= 1;
					$withdrawal = $withdrawal - TWENTY;
				}
			}
		} else {
			if ($withdrawal > 40) {
				$dep50sSum = $dep50s * FIFTY;
				while (($withdrawal % 50 != 0) && ($dep20s > 0) ) {
					$twentyNotes += 1;
					$dep20s -= 1;
					$withdrawal = $withdrawal - TWENTY;
				}
				if ($withdrawal > ($dep50s * FIFTY)) {
					while (($withdrawal % 50 != 0) && ($dep20s > 0) && ($withdrawal > $dep50sSum) ) {
						$twentyNotes += 1;
						$dep20s -= 1;
						$withdrawal = $withdrawal - TWENTY;
					}
				}
				while ( $withdrawal > 0 ) {
					$fiftyNotes += 1;
					$dep50s -= 1;
					$withdrawal = $withdrawal - FIFTY;
				}
			}
		}

		return array (
				$fiftyNotes,
				$twentyNotes 
		);
	}

	/**
	 * 
	 * @param array $withdrawalNoteTokenizer
	 * @return boolean
	 */
	public function isWithdrawalSuccessful($withdrawalNoteTokenizer) {	
		$tokenSumEqualsWitdrawal = ($withdrawalNoteTokenizer[0] * FIFTY) + ($withdrawalNoteTokenizer[1] * TWENTY) == $this->withdrawalEntry;
		//Make sure to have enough notes to dispense not just random calc - precheck.
		$deptokenEqualsOrGreater = ($this->depositFifties >= $withdrawalNoteTokenizer [0]) && ($this->depositTwenties >= $withdrawalNoteTokenizer [1]);

		return $tokenSumEqualsWitdrawal && $deptokenEqualsOrGreater;
	}

	/**
	 * @return array
	 */
	public function getReport() {
	    $withdrawalNoteTokenizer = $this->withdrawalNoteTokenizer();
        $this->withdrawalEntry = $this->withdrawalEntry != NULL ? $this->withdrawalEntry : 0;

	    $this->atmReport ["wA"] = $this->withdrawalEntry;
	    $this->atmReport ["wA50s"] = $withdrawalNoteTokenizer [0];
	    $this->atmReport ["wA20s"] = $withdrawalNoteTokenizer [1];

	    if ($this->isWithdrawalSuccessful($withdrawalNoteTokenizer)) {
	        $this->atmReport ["rAA50s"] = $this->depositFifties - $withdrawalNoteTokenizer [0];
			$this->atmReport ["rAA20s"] = $this->depositTwenties - $withdrawalNoteTokenizer [1];
			$this->maxAvailAmount = ($this->atmReport ["rAA50s"] * FIFTY) + ($this->atmReport ["rAA20s"] * TWENTY);
			$this->atmReport ["rAA"] = $this->maxAvailAmount;
			$this->atmReport ["err"] = false;
	    } else {
			// The amount can not be dispensed.
	        $this->depositFifties = $this->depositFifties != NULL ? $this->depositFifties : 0;
            $this->depositTwenties = $this->depositTwenties != NULL ? $this->depositTwenties : 0;
			$this->atmReport ["rAA50s"] = $this->depositFifties;
			$this->atmReport ["rAA20s"] = $this->depositTwenties;
			$this->maxAvailAmount = ($this->atmReport ["rAA50s"] * FIFTY) + ($this->atmReport ["rAA20s"] * TWENTY);
			$this->atmReport ["rAA"] = $this->maxAvailAmount;
			$this->atmReport ["err"] = true;
		}

		return $this->atmReport;
	}

}
