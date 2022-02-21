<?php
header("Content-Type:application/json");
include 'header.php';
require "../classes/Request.php";



if (!empty($_GET['push'])) {
    $data = $encode_data;
    $cipher_algo = 'AES-256-CBC';
    $tag_length = 16;
    $option = 0;
    $encryption_key = constant('_SALT_');                    
    $ivlen = openssl_cipher_iv_length($cipher_algo);
    $iv = '1234567896547896';                                     
    $decrypt =json_decode(base64_decode(openssl_decrypt($_GET['push'], $cipher_algo, $encryption_key, $option,  $iv , $tag_length)));

    if (!empty($decrypt->secret)) {
        $transaction = new Request();
        $user = $transaction->VerifyPaymentPush($decrypt->secret,$decrypt->amount,$decrypt->receiver);
        response(200,"Transaction Found",$user);
    }
}

if(!empty($_GET['request']))
{
    $data_payment = json_decode(base64_decode($_GET['request']));
    
    
    if ($data_payment->action == "login" && !empty($data_payment->action)) {
        $login = new Request();
        $user = $login->LoginUser($data_payment->phone,$data_payment->password);
        response(200,"User Found",$user);
    }

    if ($data_payment->action == "detail" && !empty($data_payment->action)) {
        $login = new Request();
        $user = $login->DetailUser($data_payment->phone);
        response(200,"User Found",$user);
    }

    if ($data_payment->action == "payment" && !empty($data_payment->action)) {
        $transaction = new Request();
        $user = $transaction->TransferMoneyToUser($data_payment->user,$data_payment->receiver,$data_payment->amount,$data_payment->currencie,$data_payment->note,$data_payment->transaction_type);
        response(200,"User Found",$user);
    }

    if ($data_payment->action == "register" && !empty($data_payment->action)) {
        $transaction = new Request();
        $user = $transaction->TransferMoneyToUser($data_payment->phone,$data_payment->nom,$data_payment->prenom,$data_payment->currencie,$data_payment->note,$data_payment->transaction_type);
        response(200,"User Found",$user);
    }
	
	/*if(empty($price))
	{
		response(200,"Product Not Found",NULL);
	}
	else
	{
		response(200,"Product Found",$price);
	}*/
	
}
else
{
	//response(400,"Invalid Request",NULL);
    if (!empty($_GET['reference'])) {
        $transaction = new Request();
        $user = $transaction->VerifyPayment($_GET['reference']);
        response(200,"Transaction Found",$user);
    }
}



function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	//$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

