<?php
require_once 'Class/Response.php';
//disable wsdl cache
ini_set("soap.wsdl_cache_enabled", "0");

try {

    $server = new SoapServer('xml/ornek.wsdl');

    //set the class for the soap server
    $server->setClass("Response");

    //handles soap operations
    $server->handle();

} catch (Exception $exc) {

    echo $exc->getMessage();

}