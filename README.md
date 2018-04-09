# OLKYPAY-PHP-SDK
## Creating a basic paiement order:

### Set your olkypaydata :
Initialize a client object with your Olkpay data 

    $olkypay = new \Olkypay\Client("YourClientSecret","YourUsername","YourPassword",YourNetworkId,YourSupplierId);

### Generate a token :
This tokens is valide for only 1 use.

    $request = $olkypay->post(\Olkypay\Resources::$token);
    
     if($request){  
        $token = $request->getAccessToken();  
    }
### Creat a new customer :
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
	    $clienId = $request->getCustomerId();
    }
 
 
### Creat a order for the actual customer :
Creat a array with multiple required data :

    $params = array(  
        "token" => $token,  
        "clientId" => $clienId,  
        "comment" => "MY ORDER NUMBER X",  
        "currencyCode" => "EUR",  
        "executionDate" => date('Y-m-d'),  
        "externalId" => uniqid(),  
        "nominalAmount" => 1000,  
        "packageNumber" => "MY ORDER NUMBER X",  
        "recidivism" => false,  
    );

 Call the request and get the order ID :

    $request = $olkypay->post(\Olkypay\Resources::$creatOrder,$params);  
      
    if($request){  
        $idOrder = $request->getOrderId();  
    }

