<?php
namespace App\Service;

/**
 * This MailService class for manage globally -
 * mail service in application.
 *---------------------------------------------------------------- */
class owodeService
{
    /**
     * @var configData - configData
     */
    protected $configData;

    /**
     * @var configItem - configItem
     */
    protected $configItem;

    /**
     * @var Holds IPN Information
     */
    protected $ipnInformation;

    /**
     * @var Holds Infor Errors
     */
    protected $infoErrors;

    /**
     * Constructor.
     *
     *-----------------------------------------------------------------------*/
    public function __construct() {
        $this->configData = configItem();
    }

      /**

     * @param  string $ordderData - Order ID
     * @param  string -$stripeToken - Stripe Token

     * request to Stripe checkout
     *---------------------------------------------------------------- */
    public function processowodeRequest($request)
    {   
        $configItem = [];
        $owodeData = [];
        //check config data is exist
        if (isset($this->configData)) {
            //collect instamojo data in config array
            $configItem = $this->configData['payments']['gateway_configuration']['owode'];
        }

        //set order id in $orderId variable
        $orderId = $request['order_id'];

        // Set the owode return addresses.
        $cancelReturn       = getAppUrl($configItem['cancelReturn']).'?paymentOption='.$request['paymentOption']; //add cancel return Url
        $notifyUrl          = getAppUrl($configItem['notifyIpnURl']); //add notify Ipn request Url
        $returnTo           = getAppUrl($configItem['callbackUrl']).'?paymentOption='.$request['paymentOption']; //add callback Url

        //check test mode or product mode
        //add sandbox busniess Email  else owode Production Busniess Email 
        if ($configItem['testMode'] == true) {
            $businessEmail = $configItem['owodeSandboxBusinessEmail'];
        } else {
            $businessEmail = $configItem['owodeProductionBusinessEmail'];
        }

        $currency = $configItem['currency']; //add currency

        $owodeUrl = '';
        //set owode url test mode else production mode
        if ($configItem['testMode'] == true) {
            $owodeUrl .= $configItem['owodeSandboxUrl'];
        } else {
            $owodeUrl .= $configItem['owodeProdUrl'];
        }

        // Set the details about the product being purchased, including the amount
        // and currency so that these aren't overridden by the form data.
        $itemName           = $request['item_name'];
        $orderTotalAmount   = $request['amounts'][$configItem['currency']];
        $currency           = $configItem['currency'];

        // Build the query string from the data.
        $owodeUrl     .= "?cmd=_xclick&upload=1&display=1&add=1&charset=utf-8&currency_code=$currency&business=$businessEmail&cancel_return=$cancelReturn&notify_url=$notifyUrl&rm=2&amount=$orderTotalAmount&item_name=$itemName&return=$returnTo&custom=$orderId&invoice=$orderId";

        // Redirect to owode IPN
        $owodeData['owodeUrl'] = $owodeUrl;

        //return owodeData for load owodeUrl using ajax
        return (array) $owodeData;
    }

    /**
     * process IPN Notification Request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function processIpnRequest()
    {
        // Defined IPN & other responses codes as below
        // 1 - all OK you can update order
        // ERR_IPN_NOT_COMPLETED - The payment_status is not Completed
        // ERR_IPN_TXN_EXIST - txn_id has already been previously processed
        // ERR_IPN_EMAIL_MISMATCH - receiver_email is not valid Business owode email
        // ERR_IPN_AMOUNT_MISMATCH - payment_amount is not correct
        // ERR_IPN_CURRENCY_MISMATCH - payment_currency is not correct
        // ERR_IPN_INVALID - Not Verified / INVALID
        // ERR_IPN_NOTHING - Nothing
        // ERR_IPN_ORDER_NOT_FOUND - order not found
        // ERR_IPN_FAILD / null - Connection failed - Can't connect to owode to validate IPN message

        $validatedIpnRequest = $this->validateIpnRequest(); //validateIpnRequest / validateIpnInformation

        // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        // $txt = json_encode($this->ipnInformation);
        // fwrite($myfile, $txt);
        // fclose($myfile);
      

        // Updated Payment Record & Notify concerned persons.
        if ($validatedIpnRequest === true) {
        
            return json_encode($this->ipnInformation);
        }

        if (is_array($validatedIpnRequest) and in_array('ERR_IPN_NOT_COMPLETED', $validatedIpnRequest)) {

            // mark order payment as pending
            return json_encode($this->ipnInformation);
        }

        // Notify Admin about Payment Failure & Notify concerned persons.
        return json_encode($this->ipnInformation);
    }

    /**
     * Process IPN Validations.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    protected function validateIpnRequest()
    {   
        $configItem = [];
        if (isset($this->configData)) {
            $configItem = $this->configData['payments']['gateway_configuration']['owode'];
        }

        // Read POST data
        // reading posted data directly from $_POST causes serialization
        // issues with array data in POST. Reading raw POST data from input stream instead.
        $rawPostData = file_get_contents('php://input');
        $rawPostArray = explode('&', $rawPostData);
        $myPost = array();
        foreach ($rawPostArray as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // read the post from owode system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $getMagicQuotesExists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($getMagicQuotesExists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
  
        // Post IPN data back to owode to validate the IPN data is genuine
        // Without this step anyone can fake IPN data
        if ($configItem['testMode'] == true) {
            $owodeUrl = "https://urlowode";
        } else {
            $owodeUrl = "https://www.owode.com/";
        }

        $ch = curl_init($owodeUrl);

        if ($ch == false) {
            return false;
        }


        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        //if debug mode true then set this two line 
        // curl_setopt($ch, CURLOPT_HEADER,1);   
        // curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
      
        $res = curl_exec($ch);

        if (curl_errno($ch) != 0) {
            // cURL error
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            return 'ERR_IPN_FAILD';
            // throw new Exception("cURL error: [$errno] $errstr");
            //exit;

        } else {
            curl_close($ch);
        }

        // Inspect IPN validation result and act accordingly
        // Split response headers and payload, a better way for strcmp
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));
    
        if (strcmp($res, 'VERIFIED') == 0) {

            // check whether the payment_status is Completed
            return $this->validateIpnInformation();

        } elseif (strcmp($res, 'INVALID') == 0) {
            // log for manual investigation
            // Add business logic here which deals with invalid IPN messages
            // return response for INVALID
            return 'ERR_IPN_INVALID';
        }

        return 'ERR_IPN_NOTHING';
    }

    /**
     * Validate IPN Request Information.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    protected function validateIpnInformation()
    {
        $configItem = [];
        if (isset($this->configData)) {
            $configItem = $this->configData['payments']['gateway_configuration']['owode'];
        }
       
        // get IPN request
        $this->ipnInformation = $_REQUEST;

     
        // check whether the payment_status is Completed
        if ($this->ipnInformation['payment_status'] != 'Completed') {
            $this->infoErrors[] = 'ERR_IPN_NOT_COMPLETED';
        }
      
        // check that receiver_email match with order business email
        if (($configItem['owodeSandboxBusinessEmail'] != $this->ipnInformation['business'])) {
            // set other emails
            $otherValidBusinessEmails = [$configItem['owodeProductionBusinessEmail'], $configItem['owodeSandboxBusinessEmail']
            ];

            // for owode sandbox
            if ($configItem['testMode'] == true) {
                $otherValidBusinessEmails[] = $configItem['owodeSandboxBusinessEmail'];
            }

            // check that receiver_email match with site business email
            if (!in_array($this->ipnInformation['business'], $otherValidBusinessEmails)) {
                $this->infoErrors[] = 'ERR_IPN_EMAIL_MISMATCH';
            }
        }
  
        if (!empty($this->infoErrors)) {
            return $this->infoErrors;
        }

        // it seems to be all ok!!
        return true;
    }


}