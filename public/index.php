<?php


use Core\App;

define('VERSION', '1.0 Beta');

//set true if in PRODUCTIONMODE

define('PRODUCTIONMODE', true);

//you should set your timezone here
//check this list for Asia http://php.net/manual/en/timezones.asia.php

date_default_timezone_set('Asia/Riyadh');

if (defined('PRODUCTIONMODE')) {

    if (PRODUCTIONMODE) {

        ini_set('display_errors', 0);

        error_reporting(E_ALL);
    } else {
        if (! PRODUCTIONMODE) {

            ini_set('display_errors', 1);

            error_reporting(E_ALL);
        } else {

            exit("configuration error");
        }
    }
}

//Use the DS to separate the directories

if (! defined('DS')) {

    define('DS', DIRECTORY_SEPARATOR);
}

//The full path to the directory which holds "app", WITHOUT a trailing DS.

if (! defined('ROOT')) {

    define('ROOT', dirname(dirname(dirname(__FILE__))));
}

//The actual directory name for the "app".

if (! defined('APP_DIR')) {

    define('APP_DIR', basename(dirname(dirname(__FILE__))));
}

//php extension
if (! defined('EXT')) {

    define('EXT', '.php');
}

//public directory

if (! defined('WEBROOT_DIR')) {

    define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
//full path to public directory

if (! defined('WWW_ROOT')) {

    define('WWW_ROOT', dirname(__FILE__).DS);
}

//Get App class contents

require ROOT.DS.APP_DIR.DS.'System'.DS.'Core'.DS.'App.php';

//instantiate App

$app = App::getInstance();

//Adding pretty URLs to the routes (Fixed Routes)

$app->get('route')->addRoutes(require_once '../App/routes.php');

//Here where every thing starts from (The Gate)

$app->start();



