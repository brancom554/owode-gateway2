<?php

// include header file
include 'header.php';

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo getAppUrl('assets/css/custom.css');?>" type="text/css">
    <!-- /Load JQuery, bootstrap, font-awesome, and custom css -->
</head>
<!-- /Index page head end here -->
<!-- Page body start from here... -->
<body>
    <div id="app">
        <App />
    </div>
    
    <!-- /Payment form end from here -->
    <footer class="footer bg-light p-4 text-center">
       OWODE PAYMENT. Developed by <a href="">OWODE</a>
    </footer>

    <script src="https://paydunya.com/assets/psr/js/psr.paydunya.min.js"></script>
    <script src="<?php echo getAppUrl('public/js/app.js');?>"></script>
</body>
<!-- /Page body end from here... -->
</html>