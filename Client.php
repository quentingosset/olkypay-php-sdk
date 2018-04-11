<?php
namespace Olkypay;

class Client {
    /**
     * Oklypay constructor.
     */
    private $client_secret;
    private $username;
    private $password;
    private $network_id;
    private $supplierId;
    private $token;

    public function __construct($client_secret,$username,$password,$network_id,$supplierId){
        $this->client_secret = $client_secret;
        $this->username = $username;
        $this->password = $password;
        $this->network_id = $network_id;
        $this->supplierId = $supplierId;
        $this->token = $this->setToken();
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getNetworkId()
    {
        return $this->network_id;
    }

    /**
     * @return mixed
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function post($function,$params = null){
        $request = new Request($this);
        return $request->$function($params);
    }

    public function get($function,$params = null){
        $request = new Request($this);
        return $request->$function($params);
    }

    private function setToken(){
        $request = new Request($this);
        return $request->generateToken();
    }


}