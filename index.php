<?php
//we pull in the jsonRPCClient so that the script can talk to the RPC server of the wallet

require_once 'jsonRPCClient.php'; 
$bitcoin = new jsonRPCClient('http://walletUsername:walletPassword@127.0.0.1:22555/');


//uncomment the line below to do a simple getinfo() test on the wallet to make sure it's connecting
//  print_r($bitcoin->getinfo()); echo "\n";

$call = $_GET['call'];
$params = $_GET['params'];
$key = null;
$key = $_GET['key'];

//we has together the passed params and a secret phrase. We then compare this hash to the "key" to authenticate the request.
$lock = $params . "yoursecretpassphrase";
$lock = sha1($lock);

//if the key matches, we can do stuff
if ($key == $lock){


switch($call){

	case "listreceivedbyaddress":
		$received = $bitcoin->getreceivedbyaddress($params, 0);
		echo $received;
	break;
	 
	case "getbalancbyaddress":

        $account = $bitcoin->getaccount($params);
        $balance = $bitcoin->getbalance($account, 3);
        echo $balance;
	break;
  

	case "getbalancebyaccount":

        $account = $params;
        $balance = $bitcoin->getbalance($account, 3);
        echo $balance;
       break;
 
	
	case "withdraw":
	
        $params = explode('@@@', $params);
        $address = $params[0];
		$amount = $params[1];
		$account = $params[2];
	
		$result = $bitcoin->sendfrom($account, $address, 1, 3);
		echo $result;
       break;

	}  
} 

//if the key and lock don't match:
else { 

echo "ah ah ah, you didn't say the magic word!";

}

?>  
