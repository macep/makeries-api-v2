<?php
/**
 * application folder 
 */

define('_ONLINE_MODE_', false);
define('_LOG_API_', true);

define('_APP_DIR_TYPE_', 'backend');



define('_APP_DIR_', str_replace('\\', '/', dirname(__FILE__)). '/../..');
define('_UPLOAD_DIR_', str_replace('\\', '/', dirname(__FILE__)). '/upload');

define('_UPLOAD_PROJECT_DIR_', _APP_DIR_ . '/data/projects');
define('_UPLOAD_DOCUMENT_DIR_', _APP_DIR_ . '/data/documents');

//include _APP_DIR_ . '/vendor/autoload.php';

define('_CORE_DIR_', _APP_DIR_ . '/classes/lib/core' );
/**
 * shared classes folder
 */
define('_LIB_DIR_', _APP_DIR_ . '/classes/lib' );

/**
 * modules folder 
 */
define('_PRELOAD_DIR_', _APP_DIR_ . '/data/preload/data' );
/**
 * modules folder 
 */
define('_MODULE_DIR_', _APP_DIR_ . '/modules' );

/**
 * locale folder
 */
define('_LANG_DIR_', _APP_DIR_ . '/locale' );

/**
 * cache folder
 */
define('_CACHE_DIR_', _APP_DIR_ . '/cache' );

/**
 * js folder
 */
define('_JS_DIR_', _APP_DIR_ . '/js' );

/**
 * css folder
 */
define('_CSS_DIR_', _APP_DIR_ . '/css' );

/**
 * layout folder
 */
define('_LAYOUT_DIR_', _APP_DIR_ . '/classes/app/backend/templates' );

/**
 * 
 * Encryption password
 * 
 */
define('_ENC_PASS_', 'ALDKGGS3');

/**
 * 
 * Time To Live for the authentication cookie
 */
define('_AUTH_COOKIE_TTL_', 30 * 86400);

/**
 * Array storing configuration values: key => value
 * @var array
 */
$config = array(
	'lang' => 'ro_RO'
  #/*
);
