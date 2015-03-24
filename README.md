ATM Simulator aka 'hole in the wall' doc.

Description : This is an example of ATM simulator written in PHP employing the MVC software design pattern and developed in the TDD Environment.

A. Installation instructions:

1. Git clone the repo
2. Cd to ATMSimulator/app/views/
3. Run the PHP application via CLI -- php AtmView.php
4. Follow the program instructions in the CLI.

Assumption(s):

1. Any float/decimal numbers entered when depositing will be rounded down.
2. Any combination of non-numeric value and number entered when depositing:

    A. If the value starts with numbers then all the number will be taken as valid input up until the non-numberic values that come after. e.g. 30String40 is treated as valid 30.

    B. If one of the values (either the value for the number of $50 notes or $20 notes) inserted begins with non-numeric value then it will be treated as $0 for both $50 and $20 note values e.g. 'String302@#$', if inserted, is then treated as $0 for the number of $50 notes and $20 notes.
