<?php

// wsdl cache 'ini devre disi birak
ini_set("soap.wsdl_cache_enabled", "0");

$opts = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false
    )
);

$options = array(
    'login'          => 'ornek',
    'password'       => 'ornek',
    'trace'          => 1,
    'exceptions'     => 0,
    'stream_context' => stream_context_create($opts)
);

try {


    // SOAPClient nesnesi olustur
    $client = new SoapClient("http://okesmez.com/php-soap-v2/server.php?wsdl",$options);

    $ornekInput              = new \stdClass();
    $ornekInput->name        = 'Omer';
    $ornekInput->second_name = 'Faruk';
    $ornekInput->phone       = '0000000000';
    $response = $client->ornek($ornekInput);

    if(isset($_GET['request'])){
        header("Content-type: text/xml");
        die($client->__getLastRequest());
    } else if(isset($_GET['response'])){
        header("Content-type: text/xml");
        die($client->__getLastResponse());
    }

    echo "Metod basarili bir sekilde calistirildi.<br/>Sonuc asagidadir.<br/>";
    echo  "<pre>";
    // Sonucu ekrana bas
    var_dump($response);
    echo  "</pre>";


    foreach($response as $key=>$value){
        echo '<strong>'.$key.' : </strong>'.$value.'<br>';
    }


} catch (Exception $exc) { // Hata olusursa yakala
    echo "Soap service message: " . $exc->getMessage();
}