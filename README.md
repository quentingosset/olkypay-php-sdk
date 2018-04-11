# OLKYPAY-PHP-SDK
![Olkypay logo](https://www.olkypay.com//wp-content//uploads//2017//03//logo.png)

> Olkypay is an online payment solution that accepts card payments.

I developed this library after spending several days trying to understand the olkypay system and losing some hair! This library allows you to make requests to Olkypay in a very simple way.

For open-source enthusiasts, you are welcome to support the development of this library :-) 

**STATUS: IN DEVELOPPEMENT**

### POST methode :

    $olkypay->post(\Olkypay\Resources::<NAME>,<PARAMETRE>);

| NAME           | PARAMETRE | DESCRIPTION                  |
|----------------|-----------|------------------------------|
| $token         | array     | Generate a tokens            |
| $creatCustomer | array     | Creat a customer             |
| $creatOrderSTD | array     | Creat a order for a customer |
| $dopayment     | array     | Generate payment url         |

### GET methode :

    $olkypay->get(\Olkypay\Resources::<NAME>,<PARAMETRE>);

| NAME           | PARAMETRE | DESCRIPTION                  |
|----------------|-----------|------------------------------|
| $searchOrder	| array     | Search a specific order            |
| $proofOrderSTD| array     | Get proof of STD payment           |


## Creating a basic paiement order:
### 1) Initialisation :
Add this code in top of your page :

    require_once("Resources.php");  
    require_once("Request.php");  
    require_once("Client.php");  
    require_once("Response.php");

### 2) Set your olkypaydata :
Initialize a client object with your Olkpay data 

    $olkypay = new \Olkypay\Client("YourClientSecret","YourUsername","YourPassword",YourNetworkId,YourSupplierId);

### 3) Generate a token :
This tokens is valide for only 1 use and auto generated when you initialize the object.

### 4) Creat a new customer :
Creat a array with multiple required data :


    $params = array(  
        "token" => $token,  
        "externalClientCode" => uniqid(),  
        "lastName" => "Quentin",  
        "moralPerson" => false,  
        "zipCode" => "1000",  
        "city" => "Bruxelles",  
        "countryCode" => "BE",  
        "address1" => "Grand Place, 1",  
        "firstName" => "Quentin",  
        "fullName" => "Quentin Gosset",  
        "gender" => "MR"  
    ); 

Call the request and get the customer ID :

    $request = $olkypay->post(\Olkypay\Resources::$creatCustomer,$params); 
     
    if($request){  
	    $customerId = $request->getCustomerId();
    }
 
 
### 5) Creat a order for the actual customer :
Creat a array with multiple required data :

    $params = array(  
        "token" => $token,  
        "clientId" => $customerId,  
        "comment" => "MY ORDER NUMBER X",  
        "currencyCode" => "EUR",  
        "executionDate" => date('Y-m-d'),  
        "externalId" => uniqid(),  
        "nominalAmount" => 1000,  
        "packageNumber" => "MY ORDER NUMBER X",  
        "recidivism" => false,  
    );

 Call the request and get the order ID :

    $request = $olkypay->post(\Olkypay\Resources::$creatOrderSTD,$params);  
      
    if($request){  
        $idOrder = $request->getOrderId();  
    }
### 6) Generate the payment url :
Creat a array with multiple required data :

    $params = array(  
        "token" => $token,  
        "clientId" => $customerId,  
        "support3ds" => true,  
        "urlRedirectSuccess" => "https://www.example.be/success",  
        "urlRedirectFailure" => "https://www.example.be/failure",  
        "orderId" => $idOrder,  
        "amount" => 1000  
    );

call the request and get the payment URL :

    $request = $olkypay->post(\Olkypay\Resources::$dopayment,$params);  
      
    if($request){  
        $paymentUrl = $request->getPaymentUrl();  
    }
