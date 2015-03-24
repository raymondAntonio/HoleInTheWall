<?php 

// Declare the interface 'Atm'
interface Atm {
	public function withdrawalNoteTokenizer();
	public function isWithdrawalSuccessful($withdrawalNoteTokenizer);
}