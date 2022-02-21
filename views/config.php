<?php 

$techAppConfig = [

    /* Base Path of app
    ------------------------------------------------------------------------- */
    'base_url' =>  'http://testowodegateway.mydko-sarl.com/',

    'payments' => [
        /* Gateway Configuration key
        ------------------------------------------------------------------------- */
        'gateway_configuration' => [
            'owode' => [
                'enable'                        => true,      
                'testMode'                      => true, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Owode', //payment gateway name
                'owodeSandboxBusinessEmail'        => 'Enter Owode account', //owode account for test
                'owodeProductionBusinessEmail'     => 'owode real account', //owode account for production
                'currency'                  => 'XOF', //currency
                'currencySymbol'              => 'CFA',
                'owodeSandboxUrl'          => 'lien api', //owode sandbox test mode Url
                'owodeProdUrl'             => 'lien', //owode production mode Url
                'notifyIpnURl'              => 'payment-response.php', //owode ipn request notify Url
                'cancelReturn'              => 'payment-response.php', //cancel payment Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => []
            ]
            
            
        ],
    ],

];

return compact("techAppConfig");