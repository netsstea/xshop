<?php
//require_once 'env.php';

defined('PUBLIC_PATH')
|| define('PUBLIC_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('SAND_ROOT')
|| define('SAND_ROOT', realpath(dirname(__FILE__) . '/../../../sand-core'));


require_once(SAND_ROOT . '/library/init.php');
require_once(SAND_ROOT . '/library/common.php');