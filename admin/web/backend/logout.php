<?php
session_start();
unset($_SESSION['auth0__user']);
unset($_SESSION['accountId']);
require_once('config.inc.php');
require_once(_CORE_DIR_ . '/Autoloader.php');
require_once(_CORE_DIR_ . '/core.php');
require __DIR__ . '/../../vendor/autoload.php';

// registering autoloader
spl_autoload_register(array('Autoloader', 'load'));

$router = new Router();
$router->redirect('/');