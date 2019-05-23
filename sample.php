<?php
require_once("Resources.php");
require_once("Request.php");
require_once("Client.php");
require_once("Response.php");

$olkypay = new \Olkypay\Client("YourClientSecret","YourUsername","YourPassword",YourNetworkId,YourSupplierId,"PROD");
//$olkypay = new \Olkypay\Client("YourClientSecret","YourUsername","YourPassword",YourNetworkId,YourSupplierId,"UAT");


$params = array(
    "externalClientCode"  => uniqid(),
    "lastName" => "Quentin",
    "moralPerson" => false,
    "zipCode" => "1000",
    "city" => "Bruxelles",
    "countryCode" => "BE",
    "address1" => "Grand place, 1",
    "firstName" => "quentin",
    "fullName" => "quentin gosset",
    "gender" => "MR"
);

$request = $olkypay->post(\Olkypay\Resources::$creatCustomer,$params);

if($request){
    $customerId = $request->getCustomerId();
}

$params = array(
    "clientId" => $customerId,
    "comment" => "INVOICE XXXX",
    "currencyCode" => "EUR",
    "executionDate" => date('Y-m-d'),
    "externalId" => uniqid(),
    "nominalAmount" => 1000,
    "packageNumber" => "INVOICE XXXX",
    "recidivism" => false
);

$request = $olkypay->post(\Olkypay\Resources::$creatOrderSTD,$params);
if($request){
    $idOrder = $request->getOrderId();
}

$params = array(
    "clientId" => $customerId,
    "support3ds" => true,
    "urlRedirectSuccess" => "https://www.success.be/success",
    "urlRedirectFailure" => "https://www.failure.be/failure",
    "orderId" => $idOrder,
    "amount" => 1000

);
$request = $olkypay->post(\Olkypay\Resources::$dopayment,$params);

if($request){
    $paymentUrl = $request->getPaymentUrl();
}
echo '<iframe src="'.$paymentUrl.'" height="600px" width="800px" ></iframe>';

?>
