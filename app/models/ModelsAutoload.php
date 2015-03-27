<?php

class ModelsAutoload {

  public static function autoload($class) {
      $filename = $class. '.php';
      $file = dirname(__FILE__). '/' .$filename;
      if (!file_exists($file)) {
          return false;
      }
      include $file;
  }

}
