<?php  
header('Access-Control-Allow-Origin:  *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST,PATCH,OPTIONS");


$url = 'http://owode-api.bj/api/v1/';


if (!empty($_GET['token'])) {

        //$data['mode'] = 'test';    
        $data['token'] = $_GET['token'];
        $data['success']=true;
        echo json_encode($data);
} 

$_POST = json_decode(file_get_contents("php://input"),true);
if (!empty($_POST['transaction']) && !empty($_POST['statut'])) {

    $data = array('transaction'=>$_POST['transaction'],'statut'=>$_POST['statut']);
    $data_json = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'transactions/paymentStatus');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($response,JSON_OBJECT_AS_ARRAY);
    echo json_encode(['data'=>$user]);
}

if (!empty($_POST['transactions']) && !empty($_POST['statuts'])) {

    $data = array('transaction'=>$_POST['transactions'],'statut'=>$_POST['statuts']);
    $data_json = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'merchants/paymentMerchantStatut');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($response,JSON_OBJECT_AS_ARRAY);
    echo json_encode(['data'=>$user]);
}