<?php
/**
 * Created by PhpStorm.
 * User: Myabi
 * Date: 08-04-18
 * Time: 00:03
 */

namespace Olkypay;
require_once("Client.php");
require_once("Response.php");


class Request
{


    private $client;

    public function __construct($client)
    {
       $this->client = $client;
    }

    public function ErrorMessage($string){
        echo $string."<br>";
    }

    public function generateToken(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://stp.olkypay.com/auth/realms/b2b/protocol/openid-connect/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=password&client_id=wsapi&client_secret=".$this->client->getClientSecret()."&username=".$this->client->getUsername()."&password=".$this->client->getPassword()."&client_assertion_type=urn%3Aietf%3Aparams%3Aoauth%3Aclient-assertion-type%3Ajwt-bearer",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = new Response($response);
            if(!$response->getError()){
                return $response->getAccessToken();
            }
        }
    }

    public function creatCustomer($params){
        $params = $params + array("supplierId" => $this->client->getSupplierId());
        if(sizeof($params) < 7 || !array_key_exists("externalClientCode",$params) || !array_key_exists("lastName",$params)
            || !array_key_exists("moralPerson",$params) || !array_key_exists("zipCode",$params) || !array_key_exists("city",$params)
            || !array_key_exists("countryCode",$params) || !array_key_exists("address1",$params)){
            if(!array_key_exists("externalClientCode",$params)){
                $this->ErrorMessage("Error : externalClientCode fields is required.");
            }
            if(!array_key_exists("lastName",$params)){
                $this->ErrorMessage("Error : lastName fields is required.");
            }
            if(!array_key_exists("moralPerson",$params)){
                $this->ErrorMessage("Error : moralPerson fields is required.");
            }
            if(!array_key_exists("zipCode",$params)){
                $this->ErrorMessage("Error : zipCode fields is required.");
            }
            if(!array_key_exists("city",$params)){
                $this->ErrorMessage("Error : city fields is required.");
            }
            if(!array_key_exists("countryCode",$params)){
                $this->ErrorMessage("Error : countryCode fields is required.");
            }
            if(!array_key_exists("address1",$params)){
                $this->ErrorMessage("Error : address1 fields is required.");
            }
            exit();
        }
        if(!is_bool($params['moralPerson'])){
            $this->ErrorMessage("Error : moralPerson required a boolean.");
            exit();
        }
        echo $params['moralPerson'];
        if($params['moralPerson'] == false){
            if(!array_key_exists("firstName",$params)){
                $this->ErrorMessage("Error : moralPerson is false, a optional array with \"firstName\" fields is required.");
                exit();
            }
            if(!array_key_exists("fullName",$params)){
                $this->ErrorMessage("Error : moralPerson is false, a optional array with \"fullName\" fields is required.");
                exit();
            }
            if(!array_key_exists("gender",$params)){
                $this->ErrorMessage("Error : moralPerson is false, a optional array with \"gender\" fields is required.");
                exit();
            }else{
                if(strtoupper($params['gender']) != "MR" && strtoupper($params['gender']) != "MME" && strtoupper($params['gender']) != "MR ET MME" && strtoupper($params['gender']) != "MLE"){
                    $this->ErrorMessage("Error : gender possible values : [MR, MME, MR ET MME, MLE]");
                    exit();
                }
            }
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ws.olkypay.com/payer",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "network-id: ".$this->client->getNetworkId(),
                "x-pay-token: ".$this->client->getToken()
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = new Response($response);
            if(!$response->getError()){
                return $response;
            }
        }
    }

    public function creatOrderSTD($params){
        if(sizeof($params) < 7 || !array_key_exists("clientId",$params) || !array_key_exists("comment",$params)
            || !array_key_exists("currencyCode",$params) || !array_key_exists("executionDate",$params) || !array_key_exists("externalId",$params)
            || !array_key_exists("nominalAmount",$params) || !array_key_exists("packageNumber",$params) || !array_key_exists("recidivism",$params)){
            if(!array_key_exists("clientId",$params)){
                $this->ErrorMessage("Error : clientId fields is required.");
            }
            if(!array_key_exists("comment",$params)){
                $this->ErrorMessage("Error : comment fields is required.");
            }
            if(!array_key_exists("currencyCode",$params)){
                $this->ErrorMessage("Error : currencyCode fields is required.");
            }
            if(!array_key_exists("executionDate",$params)){
                $this->ErrorMessage("Error : executionDate fields is required.");
            }
            if(!array_key_exists("externalId",$params)){
                $this->ErrorMessage("Error : externalId fields is required.");
            }
            if(!array_key_exists("nominalAmount",$params)){
                $this->ErrorMessage("Error : nominalAmount fields is required.");
            }
            if(!array_key_exists("packageNumber",$params)){
                $this->ErrorMessage("Error : packageNumber fields is required.");
            }
            if(!array_key_exists("recidivism",$params)){
                $this->ErrorMessage("Error : recidivism fields is required.");
            }
            exit();
        }
        if(!is_bool($params['recidivism'])){
            $this->ErrorMessage("Error : recidivism required a boolean.");
            exit();
        }
        if(!is_int($params['nominalAmount'])){
            $this->ErrorMessage("Error : nominalAmount required a int number.");
            exit();
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ws.olkypay.com/order/std",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "network-id: ".$this->client->getNetworkId(),
                "x-pay-token: ".$this->client->getToken()
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = new Response($response);
            if(!$response->getError()){
                return $response;
            }
        }
    }

    public function dopayment($params){
        if(sizeof($params) < 6 || !array_key_exists("clientId",$params) || !array_key_exists("support3ds",$params)
            || !array_key_exists("urlRedirectSuccess",$params) || !array_key_exists("urlRedirectFailure",$params) || !array_key_exists("orderId",$params)
            || !array_key_exists("amount",$params)){
            if(!array_key_exists("clientId",$params)){
                $this->ErrorMessage("Error : clientId fields is required.");
            }
            if(!array_key_exists("support3ds",$params)){
                $this->ErrorMessage("Error : support3ds fields is required.");
            }
            if(!array_key_exists("urlRedirectSuccess",$params)){
                $this->ErrorMessage("Error : urlRedirectSuccess fields is required.");
            }
            if(!array_key_exists("urlRedirectFailure",$params)){
                $this->ErrorMessage("Error : urlRedirectFailure fields is required.");
            }
            if(!array_key_exists("orderId",$params)){
                $this->ErrorMessage("Error : orderId fields is required.");
            }
            if(!array_key_exists("amount",$params)){
                $this->ErrorMessage("Error : amount fields is required.");
            }
            exit();
        }
        if(!is_bool($params['support3ds'])){
            $this->ErrorMessage("Error : support3ds required a boolean.");
            exit();
        }
        if(!is_int($params['amount'])){
            $this->ErrorMessage("Error : amount required a int number.");
            exit();
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ws.olkypay.com/card/form/dopayment",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "network-id: ".$this->client->getNetworkId(),
                "x-pay-token: ".$this->client->getToken()
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = new Response($response);
            if(!$response->getError()){
                return $response;
            }
        }
    }

    /**
     * PAS FINISH
     */
    public function proofOrderSTD($params){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ws.olkypay.com/order/std/proof/".$params['idOrder'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "network-id: ".$this->client->getNetworkId(),
                "x-pay-token: ".$this->client->getToken()
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = new Response($response);
            var_dump($response);
            if(!$response->getError()){
                return $response;
            }
        }
    }

    public function searchOrder($params){
        if(sizeof($params) == 0){
            $this->ErrorMessage("Error : [idOrder] or [externalId] fields is required.");
            exit();
        }
        if(array_key_exists('idOrder', $params) && array_key_exists('externalId', $params) || sizeof($params) > 1){
            $this->ErrorMessage("Error : only [idOrder] or [externalId] fields is required.");
            exit();
        }else{
                if(array_key_exists('idOrder', $params)){
                    if(!is_int($params['idOrder'])){
                        $this->ErrorMessage("Error : [idOrder] required a int number.");
                        exit();
                    }else{
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://ws.olkypay.com/order/".$params['idOrder'],
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Accept: application/json",
                                "Content-Type: application/json",
                                "network-id: ".$this->client->getNetworkId(),
                                "x-pay-token: ".$this->client->getToken()
                            ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                            echo "cURL Error #:" . $err;
                        } else {
                            $response = new Response($response);
                            if(!$response->getError()){
                                return $response;
                            }
                        }
                    }
                }
                if(array_key_exists('externalId', $params)){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://ws.olkypay.com/order/externalid/".$params['externalId'],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "Accept: application/json",
                            "Content-Type: application/json",
                            "network-id: ".$this->client->getNetworkId(),
                            "x-pay-token: ".$this->client->getToken()
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $response = new Response($response);
                        if(!$response->getError()){
                            return $response;
                        }
                    }
                }
            }
    }

}