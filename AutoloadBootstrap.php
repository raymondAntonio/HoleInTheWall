<?php
require_once(dirname(__FILE__).'/app/models/ModelsAutoload.php');
spl_autoload_register("ModelsAutoload::autoload");