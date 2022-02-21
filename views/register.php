<?php 

session_start();
// Include header file
include 'header.php';

require '../vendor/autoload.php';

    $url='https://restcountries.com/v2/all';
    //$data_json = http_build_query($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://restcountries.com/v2/all');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
    curl_setopt($curl, CURLOPT_HEADER, false);*/
    
    $response  = curl_exec($curl);
    if (curl_errno($curl)) { echo curl_error($curl); }
    else { echo $result; }
    curl_close($curl);
    /*$client = new \GuzzleHttp\Client();
    $response = $client->get($url);

    $responseContents = $response->getBody();*/

    //$data = json_decode($response);
    //$client = new \GuzzleHttp\Client(['base_uri' => 'https://restcountries.com/v3.1/']);
    // Send a request to https://foo.com/api/test
    //$response = $client->request('GET', 'subregion/africa');
    // Send a request to https://foo.com/root
    var_dump($response);

 if (!empty($_POST['phone'] && !empty('password'))) {
    header('Location: '. getAppUrl('payment.php'));   
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
            <div class="col-md-12 col-lg-12">
                <div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="w-25">
                            <img class="lw-logo" src="assets/imgs/logo-for-site.png">
                        </div>
                        
                    </div>
                    <hr class="mb-4">
                    <div>
                        <div class="text-center">
                            <h4 class="mb-4">
                                Création de compte <span style="color: #007bff;font-weight: 700;">Owode</span>
                            </h4>
                        </div>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone" id="nom" aria-describedby="emailHelp" placeholder="Nom">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="prenoms" id="exampleInputPassword1" placeholder="Prénom">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone" id="phone" aria-describedby="emailHelp" placeholder="Numéro téléphone">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Mot de passe">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Répéter le mot de passe">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Créer un compte</button>
                        </form>
                        <div class="py-2 text-center">
                            <a href="">J'ai déjà un compte owode</a>
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



