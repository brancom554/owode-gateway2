<?php  
// Include Header file
include 'header.php';

/*
 * Use owodeService Class
 */
use App\Components\Payment\PaymentProcess;
use App\Service\owodeService;



/*
 * Get instance of owode service
 */
$owodeService      = new owodeService();



/*
 * Process a payment with anyone service
 */
$paymentProcess     = new PaymentProcess(
                                
                                $owodeService
                                
                        );  
/*
 * Get instance of GUMP, its a validation library for PHP
 */
$gump = new GUMP();

//check post data is not empty
if (isset($_POST) && count($_POST) > 0 ) {
    // Sanitize form input data, remove tags for security purpose
    $insertData = $gump->sanitize($_POST);

    // Apply validation rule for post request.
    $validation = GUMP::is_valid($insertData, array(
        'amount'        => 'required|numeric|min_numeric,0',
        'paymentOption' => 'required'
    ));
  
    $paymentOption = $insertData['paymentOption'];
    
    // Check if iyzico or authorize-net payment method is used then check iyzico or authorize-net form data like
    // amount, option, cardname, card number, expiry month, expiry year, cvv etc and validate it
  

    // Check server side validation success then process for next step
    if ($validation === true) {

        // Then send data to payment process service for process payment
        // This service will return payment data
        $paymentData = $paymentProcess->getPaymentData($insertData);

        // set select payment option in return paymentData array
        $paymentData['paymentOption'] = $paymentOption;

         if ($paymentOption == 'owode' ) {

            // return payment array on ajax request
            echo json_encode($paymentData);    

        } else {
            echo json_encode(array_values($paymentData)[0]);
        }

    } else {
        // If Validation errors occurred then show it on the form
        $validationMessage = [];
        
        // get collection of validation messages
        foreach ($validation as $valid) {
            $validationMessage['validationMessage'][] = strip_tags($valid);
        }
      
        // return validation array on ajax request
        echo json_encode($validationMessage);
        
        exit();
    }
}