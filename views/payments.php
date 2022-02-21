<?php  
session_start();

// include header file
include 'header.php';
// Get config data
$configData = configItem();

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
    <link rel="stylesheet" href="<?php echo getAppUrl('assets/css/custom.css');?>" type="text/css">
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
    <div class="bg-cards">
        <div class="container py-50">
            <div class="row border" style="border-radius: 10px; box-shadow: 0 0 20px 3px rgba(0, 0, 0, 0.05);">
                <div class="col-md-4 p-4 col-lg-4 card-detail">
                    <div>
                        <div>
                            <span class="white">Destinateur</span>
                            
                        </div>
                        <h5 class="white"><?=$_SESSION['receiver_name']?></h5>
                    </div>
                    <hr class="mb-4">
                    <div class="p-2">
                        <div class="mb-2">
                            <i class="fa fa-money white" aria-hidden="true"></i>

                            <span class="white margin-title">Montant:</span>
                            
                        </div>
                        <span class="white margin-sub font-weight-bold"><?=$_SESSION['amount']?> XOF</span>
                    </div>
                    <hr class="mb-4">
                    <div class="p-2">
                        <div class="mb-2">
                            <i class="fa fa-calendar white" aria-hidden="true"></i>

                            <span class="white margin-title">Date:</span>
                            
                        </div>
                        <span class="white margin-sub font-weight-bold"><?=date('d-m-Y')?></span>
                    </div>
                    <hr class="mb-4">
                    <div class="p-2">
                        <div class="mb-2">
                            <i class="fa fa-users white" aria-hidden="true"></i>

                            <span class="white margin-title">Tontine:</span>
                            
                        </div>
                        <span class="white margin-sub font-weight-bold">30/01/2022</span>
                    </div>
                </div>
                <div class="col-md-8 p-4 col-lg-8 bg-white">
                    <div >
                        <img class="width-140" src="assets/imgs/logo-for-site.png" alt="">
                    </div>
                    <hr class="mb-4">
                    <div class="py-3">
                        <span style="color:#58636a">
                            <b>Motif de la transaction</b> : <?=$_SESSION['motif']?>
                        </span>
                        
                    </div>
                    <div class="py-3">
                        <span style="color:#58636a">
                            <b>Montant de la transaction</b> : <?=$_SESSION['amount']?> XOF
                        </span>
                        
                    </div>
                    <hr class="mb-4">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg my-2"><i class="fa fa-handshake-o" aria-hidden="true"></i> Accepter payement</button>
                        <button type="button" class="btn btn-danger btn-lg my-2"><i class="fa fa-times-circle-o" aria-hidden="true"></i>
 Refuser  payement</button>
                    </div>
                    <hr class="mb-5">
                </div>
                </div>
        </div>
    </div>

    <div class="bg-cards">
        <div class="container py-50">
            <div class="row border" style="border-radius: 10px; box-shadow: 0 0 20px 3px rgba(0, 0, 0, 0.05);background-color: #fff;">
                <div class="col-md-12">
                    <div class="py-4">
                        <div class="text-center my-4">
                            <img class="width-140" src="assets/imgs/logo-for-site.png" alt="">
                        </div>
                        <div class="text-center my-4">
                            <svg class="w-25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                <circle style="fill:#25AE88;" cx="25" cy="25" r="25"/>
                                <polyline style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="
                                    38,15 22,33 12,25 "/>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                            </svg>
                        </div>

                        <div class="text-center my-4">
                            <span class="span-success" style="font-size: 2rem !important;color: #25ae88 !important;">Paiement réussi !</span>
                        </div>
                        <div class="text-center my-2">
                            <span style="font-size: 1.5rem !important"><?=$_SESSION['amount']?> XOF</span>
                        </div>
                        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-cards">
        <div class="container py-50">
            <div class="row border" style="border-radius: 10px; box-shadow: 0 0 20px 3px rgba(0, 0, 0, 0.05);background-color: #fff;">
                <div class="col-md-12">
                    <div class="py-4">
                        <div class="text-center my-4">
                            <img class="width-140" src="assets/imgs/logo-for-site.png" alt="">
                        </div>
                        <div class="text-center my-4">
                        <svg class="w-25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                            <circle style="fill:#D75A4A;" cx="25" cy="25" r="25"/>
                            <polyline style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" points="16,34 25,25 34,16 
                                "/>
                            <polyline style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" points="16,16 25,25 34,34 
                                "/>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                        </svg>
                        </div>

                        <div class="text-center my-4">
                            <span class="span-success" style="font-size: 2rem !important;color: #d75a4a !important;">Paiement réfusé !</span>
                        </div>
                        <div class="text-center my-2">
                            <span style="font-size: 1.5rem !important"><?=$_SESSION['amount']?> XOF</span>
                        </div>
                        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
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