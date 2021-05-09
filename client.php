<?php

// wsdl cache 'ini devre disi birak
ini_set("soap.wsdl_cache_enabled", "0");

try {

    // SOAPClient nesnesi olustur
    $client = new SoapClient("http://okesmez.com/php-soap-v2/server.php?wsdl");

    $ornekInput              = new \stdClass();
    $ornekInput->name        = 'Omer';
    $ornekInput->second_name = 'Faruk';
    $ornekInput->phone       = '0000000000';
    
    $response = $client->ornek($ornekInput);

    echo "Metod basarili bir sekilde calistirildi.<br/>Sonuc asagidadir.<br/>";

    echo  "<pre>";
    // Sonucu ekrana bas
    var_dump($response);
    echo  "</pre>";
} catch (Exception $exc) { // Hata olusursa yakala
    echo "Soap Hatasi Olustu: " . $exc->getMessage();
}