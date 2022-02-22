<?php  

if (!empty($_GET['token'])) {

        //$data['mode'] = 'test';    
        $data['token'] = $_GET['token'];
        $data['success']=true;
        echo json_encode($data);
} else {
    # code...
}
