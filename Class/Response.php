<?php


class Response
{
    private $authenticate = 1;
    private $ornekOutput;

    public function __construct()
    {
        $this->ornekOutput                 = new \stdClass();
        $this->ornekOutput->status         = '200';
        $this->ornekOutput->message        = 'Success';

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="401 Unauthorized"');
            header('HTTP/1.0 401 Unauthorized');
            $this->authenticate          = 0;

            $this->ornekOutput->status   = '401';
            $this->ornekOutput->message  = 'Unauthorized';
        } else {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
            if($username!='ornek' || $password!='ornek'){
                header('WWW-Authenticate: Basic realm="401 Unauthorized"');
                header('HTTP/1.0 401 Unauthorized');

                $this->ornekOutput->status   = '401';
                $this->ornekOutput->message  = 'Unauthorized';

                $this->authenticate          = 0;
            }
        }
    }

    public function ornek($data){
        if($this->authenticate == 1){
            $this->ornekOutput->name           = $data->name." ".$data->second_name;
            $this->ornekOutput->phone          = $data->phone;
        }

        return $this->ornekOutput;
    }

}