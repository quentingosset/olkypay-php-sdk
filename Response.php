<?php

namespace Olkypay;

class Response{

    function __construct($body){
        $this->body = json_decode($body);
    }

    public function getBody(){
        return $this->body;
    }

    public function getAccessToken(){
        return $this->body->access_token;
    }


    public function getError(){
        if(!empty($this->body->error)){
            echo $this->getErrorMessage();
            exit();
        }
        if(!empty($this->body->errorCode)){
            echo $this->getErrorMessage();
            exit();
        }else{
            return 0;
        }
    }

    public function getErrorMessage(){
        if(!empty($this->body->error_description)){
            return $this->body->error_description;
        }
        if(!empty($this->body->content)){
            return $this->body->content->messages[0];
        }
        if(!empty($this->body->message)){
            return $this->body->message;
        }
    }

    public function getCustomerId(){
        return intval($this->body->id);
    }

    public function getOrderId(){
        return intval($this->body->id);
    }

    public function getPaymentUrl(){
        return $this->body->url."?token=".$this->body->token;
    }

    public function getOrderStatus(){
        if(!empty($this->body->orderStatus)){
            return $this->body->orderStatus;
        }
        return 0;
    }

}
