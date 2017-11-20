<?php

/* 
 * Class autoload !
 */

include_once '/home/vedran/Projects/dev/public/symfony3.3/vendor/autoload.php';


$classLoader = new \Composer\Autoload\ClassLoader();
//$classLoader->addPsr4("JobAd\\", __DIR__.'../src/', true);
$classLoader->addPsr4("JobAd\\Tests\\", __DIR__, true);
$classLoader->register();