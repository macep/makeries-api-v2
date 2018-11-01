<?php

#include 'lib/AltoRouter.php';

$altoRouter = new AltoRouter();
$altoRouter->setBasePath('');

$altoRouter->map('GET','/', array('c' => 'Page', 'a' => 'home'),'homepage');
$altoRouter->map('GET','/client/', array('c' => 'Client', 'a' => 'index'),'clients');
