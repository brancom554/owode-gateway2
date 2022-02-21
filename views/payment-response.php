<?php
// Include Header file
include 'header.php';

/*
 * Use PaytmResponse Class
 * Use PaystackResponse Class
 * Use StripeResponse Class
 * Use RazorpayResponse Class
 * Use InstamojoResponse Class
 * Use IyzicoResponse Class
 * Use owodeIpnResponse Class
  * Use BitPayResponse Class
 */
use App\Components\Payment\PaytmResponse;
use App\Components\Payment\PaystackResponse;
use App\Components\Payment\StripeResponse;
use App\Components\Payment\RazorpayResponse;
use App\Components\Payment\InstamojoResponse;
use App\Components\Payment\IyzicoResponse;
use App\Components\Payment\owodeIpnResponse;
use App\Components\Payment\BitPayResponse;
use App\Components\Payment\MercadopagoResponse;

// Get Config Data 
$configData = configItem();
// Get Request Data when payment success or failed
$requestData = $_REQUEST;

 if ($requestData['paymentOption'] == 'owode') {
    // Get instance of owode 
    $owodeIpnResponse  = new owodeIpnResponse();

    // fetch owode payment data
    $owodeIpnData = $owodeIpnResponse->getowodePaymentData();
    $rawData = json_decode($owodeIpnData, true);

    // Note : IPN and redirects will come here
    // Check if payment status exist and it is success
    if (isset($requestData['payment_status']) and $requestData['payment_status'] == "Completed") {

        // Then create a data for success owode data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $owodeIpnData,
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], $rawData['txn_id'], 'owode')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    // Check if payment not successfull    
    } else {
        // Prepare payment failed data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => [],
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], null, 'owode')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }

// Check Paystack payment process
}   

/*
 * This payment used for get Success / Failed data for any payment method.
 *
 * @param array $paymentResponseData - contains : status and rawData
 *
 */
function paymentResponse($paymentResponseData) {
    // payment status success
    if ($paymentResponseData['status'] === true) {

        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: '. getAppUrl('payment-success.php'));        

    } elseif ($paymentResponseData['status'] === 'pending') {

        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: '. getAppUrl('payment-pending.php'));      

    } else {        
        // Show payment error page or do whatever you want, like send email, notify to user etc
        header('Location: '. getAppUrl('payment-failed.php'));
    }
}

/*
* Prepare Payment Data.
*
* @param array $paymentData
*
*/
function preparePaymentData($orderId, $amount, $txnId, $paymentGateway) {
    return [
        'order_id'              => $orderId,
        'amount'                => $amount,
        'payment_reference_id'  => $txnId,
        'payment_gatway'        => $paymentGateway
    ];
}