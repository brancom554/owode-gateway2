<?php

require '../vendor/autoload.php';

class Request
{

    private $url;

    public function __construct(){    
    $this->url ='http://testowodeapi.mydko-sarl.com/api/v1/' ;

   }

    public function LoginUser(string $phone,$password):array
    {
        $options = [
            
                "contact" => $phone,
                "password" => $password
            
        ];
        $data_json = http_build_query($options);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'users/login');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $user = json_decode($response,JSON_OBJECT_AS_ARRAY);
        $user_data = $user[user];
        if (!empty($user['errorMessage'])) {
            return ['user'=>[],'ErrorMessage'=>$user['errorMessage']];
        }

       //return ['user_id' => $user_data['id'],'username'=>$user_data['last_name'].' '.$user_data['first_name']];
       return ['user'=>['id'=>$user_data['id'],'first_name'=>$user_data['first_name'],'last_name'=>$user_data['last_name']],'ErrorMessage'=>$user['errorMessage']];
    }

    public function TransferMoneyToUser(string $user,$receiver,$amount,$currencie,$note,$transaction_type):array
    {
        $data_json = http_build_query(['user'=>$user]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $user1 = json_decode($response,JSON_OBJECT_AS_ARRAY);
        $user_data1 = $user1[user];
        
        if (!empty($user_data1['id'])) {

            $data_json = http_build_query(['user'=>$receiver]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response2  = curl_exec($ch);
            curl_close($ch);

            $user = json_decode($response2,JSON_OBJECT_AS_ARRAY);
            $user_data = $user[user];
            /*var_dump($user_data['id']);
            exit();*/
            if (!empty($user_data['id'])) {
                $options = [
                    "user" => $user_data1['id'],
                    "receiver" => $user_data['id'],
                    "currencie" => $currencie,
                    "amount" => $amount,
                    "note" => $note,
                    "transaction_type_id" => $transaction_type
                ];
                $data_json = http_build_query($options);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url.'transactions/transferToUser');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
                curl_close($ch);
        
                $result = json_decode($response,true,4,JSON_OBJECT_AS_ARRAY);
                $result_data = $result['transfer'];
                /*var_dump($result);
                exit();*/
                //}
                if (!empty($result['transfer'])) {
                    return ['payment'=>$result_data,'ErrorMessage'=>$result['ErrorMessage']];
                }else {
                    return ['payment'=>[],'ErrorMessage'=>$result['solde']];
                }
            }else {
                return ['payment'=>[],'ErrorMessage'=>'Le numéro owode du destinateur n\'existe pas.'];
            }

        }else {
            return ['payment'=>[],'ErrorMessage'=>'Le numéro owode  n\'existe pas.'];
        }

        //$reciver = json_decode($response,JSON_OBJECT_AS_ARRAY);
        //$user = json_decode($response2,JSON_OBJECT_AS_ARRAY);
        
        /*$user_data = $user['user'];
        $reciver_data = $reciver[user];*/
        //if (!empty($reciver_data['id'])) {
    }

    public function PaymentMoneyToUser(string $secret,$amount,$currencie,$transaction_type):array
    {
        /*$data_json = http_build_query(['user'=>$user]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $user1 = json_decode($response,JSON_OBJECT_AS_ARRAY);
        $user_data1 = $user1[user];*/
        
        //if (!empty($user_data1['id'])) {

            /*$data_json = http_build_query(['user'=>$receiver]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response2  = curl_exec($ch);
            curl_close($ch);

            $user = json_decode($response2,JSON_OBJECT_AS_ARRAY);
            $user_data = $user[user];
            /*var_dump($user_data['id']);
            exit();*/
            //if (!empty($user_data['id'])) {
                $options = [
                    "currencie" => $currencie,
                    "amount" => $amount,
                    "transaction_type_id" => $transaction_type,
                    "secret"=>$secret
                ];
                $data_json = http_build_query($options);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url.'merchants/payment');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
                curl_close($ch);
        
                $result = json_decode($response,true,4,JSON_OBJECT_AS_ARRAY);
                $result_data = $result['transfer'];
                /*var_dump($result);
                exit();*/
                //}
                if (!empty($result['transfer'])) {
                    return ['payment'=>$result_data,'ErrorMessage'=>$result['ErrorMessage']];
                }else {
                    return ['payment'=>[],'ErrorMessage'=>$result['solde']];
                }
            /*}else {
                return ['payment'=>[],'ErrorMessage'=>'Le numéro owode du destinateur n\'existe pas.'];
            }*/

        /*}else { 
            return ['payment'=>[],'ErrorMessage'=>'Le numéro owode  n\'existe pas.'];
        }*/

        //$reciver = json_decode($response,JSON_OBJECT_AS_ARRAY);
        //$user = json_decode($response2,JSON_OBJECT_AS_ARRAY);
        
        /*$user_data = $user['user'];
        $reciver_data = $reciver[user];*/
        //if (!empty($reciver_data['id'])) {
    }

    public function DetailUser(string $user):array
    {
        $data_json = http_build_query(['user'=>$user]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        /*$data_json = http_build_query(['user'=>$user]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'users/phone');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response2  = curl_exec($ch);
        curl_close($ch);*/

        $reciver = json_decode($response,JSON_OBJECT_AS_ARRAY);
        //$user = json_decode($response2,JSON_OBJECT_AS_ARRAY);
        
        //$user_data = $user['user'];
        $reciver_data = $reciver[user];
        if (!empty($reciver_data['id'])) {
            return ['user'=>['id'=>$reciver_data['id'],'first_name'=>$reciver_data['first_name'],'last_name'=>$reciver_data['last_name']],'ErrorMessage'=>$reciver['errorMessage']];
        }
        else {
            return ['user'=>[],'ErrorMessage'=>'Le numéro n\'existe pas. Veuillez créer un compte.'];
        }
    }

    public function VerifyPayment(string $transaction):array
    {
        $data_json = http_build_query(['transaction'=>$transaction]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'merchants/verify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $reciver = json_decode($response,JSON_OBJECT_AS_ARRAY);
        
        $reciver_data = $reciver['detail'];
        if (!empty($reciver_data)) {
            return ['transaction'=>$reciver_data,'ErrorMessage'=>$reciver['errorMessage']];
        }
        else {
            return ['transaction'=>[],'ErrorMessage'=>$reciver['errorMessage']];
        }
    }

    public function VerifyPaymentPush(string $secret,$amount,$receiver)
    {
        $data_json = http_build_query(['secret'=>$secret,'receiver'=>$receiver,'amount'=>$amount]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'merchants/transaction');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        
        $reciver = json_decode($response,JSON_OBJECT_AS_ARRAY); 
        $response = $reciver;
        
        if (!empty($response['errorMessage'])) {
            return ['ErrorMessage'=>$response['errorMessage']];
        } 
        else {
            return ['ErrorMessage'=>'Erreur. Veuillez réessayer ultérieurement'];
        }
    }
}
