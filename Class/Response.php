<?php


class Response
{
    public function ornek($data){
        $ornekOutput                 = new \stdClass();
        $ornekOutput->status         = 'Success';
        $ornekOutput->name           = $data->name." ".$data->second_name;
        $ornekOutput->phone          = $data->phone;
        return $ornekOutput;
    }

}