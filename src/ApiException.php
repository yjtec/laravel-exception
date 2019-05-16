<?php
namespace Yjtec\Exception;
use Exception;
class ApiException extends Exception{
    public function __construct($code,$extra=[]){
        $this->code = $code;
        $this->extra = $extra;
    }

    public function getExtra(){
        return $this->extra;
    }
}