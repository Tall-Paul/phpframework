<?php

define("LEGACY_ENABLED",true);
include("autoloader.php");
//framework
$framework = new base_main_framework(realpath(dirname(__FILE__)));
$path = $framework->parse_current_url(PHP_URL_PATH);
if (!$framework->display_static_file($path)){ //try and display the request as a static file
    $framework->router->load(realpath(dirname(__FILE__))."/routes.json"); //load routing table
    if (!$framework->handle($path)){
        die("legacy routing needs to go here!!");
        $site = Site::get(); //or whatever
        //do some legacy stuff here?
    }       
}
