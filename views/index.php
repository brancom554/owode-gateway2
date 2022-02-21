<?php 

session_start();


// Include header file
include 'header.php';
?>

<?php

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$url = 'http://owode-api.bj/api/v1/';

if (!empty($_GET['payment'])) {
    $data_payment = json_decode(base64_decode($_GET['payment']));
    // User data to send using HTTP POST method in curl
    $data = array('user'=>$data_payment->receiver);
    $data_json = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'users/infos');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    
    $user = json_decode($response,JSON_OBJECT_AS_ARRAY);
    $_SESSION['amount'] = $data_payment->amount;
    $_SESSION['receiver'] = $data_payment->receiver;
    $_SESSION['motif'] = $data_payment->note;
    $_SESSION['receiver_name'] = $user['user']['first_name'].' '.$user['user']['last_name'];
    
}

 if (!empty($_POST['phone'] && !empty($_POST['password']))) {

    $data = array('contact'=>$_POST['phone'],'password'=>$_POST['password']);
    $data_json = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'users/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($response,JSON_OBJECT_AS_ARRAY);
    if ($user['codeTraitement'] === 0) {
        $_SESSION['username'] = $user['user']['first_name'].' '.$user['user']['last_name'];
        $_SESSION['userid'] = $user['user']['id'];

        
        $extra = 'payment.php';
        header("Location: http://$host$uri/$extra");
    }else {
        $message = $user->errorMessage;
    } 
 }
?>
<!-- Page HTML Start here -->
<!DOCTYPE html>
<html>
<!-- Index page head start here -->
<head>
    <!-- Page Title -->
    <title>Pay with owode</title>
    <!-- Page Title -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load JQuery, bootstrap, font-awesome, and custom css -->
    <script src="<?php echo getAppUrl();?>./assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo getAppUrl();?>./assets/css/custom.css" type="text/css">
    <!-- /Load JQuery, bootstrap, font-awesome, and custom css -->
</head>
<!-- /Index page head end here -->
<!-- Page body start from here... -->
<body>
    <!-- Show loader when process payment request -->
    <div class="d-flex justify-content-center">
        <div class="lw-page-loader lw-show-till-loading">
            <div class="spinner-border"  role="status"></div>
        </div>
    </div>
    <!-- Show loader when process payment request -->

    <!-- Payment form start from here -->
    <div class="container py-50">
        <div class="row border py-3">
            <div class="col-md-6 col-lg-6">
                <div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="w-25">
                            <img class="lw-logo w-100" src="assets/imgs/logo-for-site.png">
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-cart-plus font-size" aria-hidden="true"></i>
                            <h6 class="ml-2 font-weight-bold">
                                <?=$_SESSION['amount']?> XOF
                            </h6>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div>
                        <div>
                            <h4 class="mb-4">
                                Payer avec Owode
                            </h4>
                        </div>
                        <form action="" method="post">
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?=$message?>
                                </div>
                            <?php endif ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone" id="phone" aria-describedby="emailHelp" placeholder="Numéro téléphone">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Mot de passe">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                        </form>
                        <div class="py-2 text-center">
                            <a href="">J'ai oublié mon mot de passe?</a>
                        </div>
                        <hr class="mb-4">
                        <div class="mb-3">
                            <a class="btn bg-gris btn-lg btn-block" href="register.php">Créer un compte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- /Payment form end from here -->
    <footer class="footer bg-light p-4 text-center">
       OWODE PAYMENT. Developed by <a href="">OWODE</a>
    </footer>
</body>
<!-- /Page body end from here... -->
</html>
<!-- /Page HTML end here -->
<!-- get configuration data -->



