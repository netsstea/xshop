<?php
define('SPAN12', 'col-md-12');
define('SPAN3', 'col-md-3');
define('SPAN4', 'col-md-4');
define('SPAN1', 'col-md-1');
define('bootstrap3', 1);

defined('PUBLIC_PATH')
|| define('PUBLIC_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('SAND_ROOT')
|| define('SAND_ROOT', realpath(dirname(__FILE__) . '/../../sand-core'));

require_once(SAND_ROOT . '/library/init.php');
require_once(SAND_ROOT . '/library/common.php');

//check for _cl_campain . For affiliate program
$key = 'c';
$oneyear = 60 * 60 * 24 * 365 + time();
// if _cl_campaign is set and 
if (get_value(COOKIE_PREFIX . $key) != '' && 
     !isset($_COOKIE[COOKIE_PREFIX . $key]))
{
    $campaign = get_value(COOKIE_PREFIX . $key);
    set_cookie('c', $campaign, $oneyear);
    $from = parse_url($_SERVER['HTTP_REFERER']);
    $website = strtolower($from['host']);
    set_cookie('f', $website);
    $redis = init_redis(RDB_CACHE_DB);
    $redis->incr("aff:{$campaign}");
}

//require_once('check-cache.php');

//cache is not ok. Now bootstrap the whole thing

/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		APPLICATION_PATH . '/configs/application.ini'
);

try 
{
$application->bootstrap()
    ->run();
}
catch (Exception $e)
{
    v($e->getMessage());
}
