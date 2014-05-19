Read Me

DogePos wallet API 1.1



::SCRIPT SETUP:: 

In the script, replace the walletUsername and walletPassword on line 5
$bitcoin = new jsonRPCClient('http://walletUsername:walletPassword@127.0.0.1:22555/');

and

replace yoursecretpassphrase on line 17
$lock = $params . "yoursecretpassphrase";




::SERVER SETUP::

These files need to be installed in the web root of your server running your dogecoin/bitcoin wallets. You can set your wallet address in your .conf file. It can usually be found somewhere like ~/.dogecoind/dogecoin.conf

Your conf file should look somethinglike:

daemon=1
rpcuser=walletUsername
rpcpassword=walletPassword
rpcport=22555
rpcallowip=127.0.0.1
rpcallowip=192.168.1.*
rpcallowip=0.0.0.0

Replace walletUsername and walletPassword with your own secret credentials.



::USAGE::

You will connect to the API using cURL, and pass the call and params you wish to execute, along with the "key" to open the authorization lock.

<?php
	
	$address = "someDogecoinAddressHere";
	
    $key = $address."yoursecretpassphrase";
	$key = sha1($key);
	
	//replace the ip address with that of your actual wallet server:
	$url = 	'http://192.168.1.1/index.php?call=listreceivedbyaddress&params='.$address.'&key='.$key;
	
	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//execute post
	$result = curl_exec($ch);
	
	//close connection
	curl_close($ch);

?>

The server's response is stored in $result


