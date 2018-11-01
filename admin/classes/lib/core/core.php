<?php

function include_component($className, $action) {
  if ('' == $action) {
    $action = 'index';
  }
  $fileName = _APP_DIR_ . '/classes/app/'._APP_DIR_TYPE_.'/modules/'.strtolower($className).'/actions/components.class.php';
  try {
    if( file_exists($fileName) ) {
      require_once($fileName);
    } else {
      print 'Component '.$className.' not defined';
      exit;
    }
    $modulename = $className.'Components';
    $class = new $modulename;
#var_dump($class);
    $actionName = 'execute' . ucfirst($action);
    if( ! method_exists($class, $actionName) ) {
      throw new Exception('Method '.$action .' not found in class '.$modulename);
    }
    $class->$actionName();
    echo $class->render->renderView( _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_ .'/modules/'.strtolower($className).'/templates/components/'.strtolower($action).'Success.php');
  } Catch(Exception $e) {
    print '<pre>';
    var_dump($e.message);
  }
}

function include_partial($className, $action, $params = null) {
  if ('' == $action) {
    $action = 'index';
  }
  $fileName = _APP_DIR_ . '/classes/app/'._APP_DIR_TYPE_.'/modules/'.strtolower($className).'/actions/partials.class.php';
  try {
    if( file_exists($fileName) ) {
      require_once($fileName);
    } else {
      print '<br><br>Partial '.$className.' not defined';
      exit;
    }
    $modulename = $className.'Partials';
    $class = new $modulename;
#var_dump($class);
    $actionName = 'execute' . ucfirst($action);
    if( ! method_exists($class, $actionName) ) {
      throw new Exception('Method '.$action .' not found in class '.$modulename);
    }
    $class->$actionName($params);
    echo $class->render->renderView( _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_ .'/modules/'.strtolower($className).'/templates/partials/'.strtolower($action).'Success.php');
  } Catch(Exception $e) {
    print '<pre>';
    var_dump($e.message);
  }
}

function include_helper($name ) {
  $fileName = _LIB_DIR_ . '/helper/'.strtolower($name).'Helper.php';
  if( file_exists($fileName) ) {
    require_once($fileName);
  } else {
    print '<br><br>Helper'.$className.' not defined';
    exit;
  }
}

function slugify($text) {
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

#include_helper('math');
include_helper('link');