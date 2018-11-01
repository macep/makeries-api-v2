<?php

class Breadcrumb {
  
  public static $data;
  
  static public function add($link, $name) {
    self::$data[] = array('link'=>$link, 'name'=>$name);
  }
  
  static public function get() {
    return self::$data;
  }
}
