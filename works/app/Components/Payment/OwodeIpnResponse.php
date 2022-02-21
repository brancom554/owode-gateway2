<?php
namespace App\Components\Payment;

use App\Service\owodeService;

class owodeIpnResponse { 

    /**
     * @var owodeService - RazorpayService
     */
    protected $owodeService;

    //construt method
    function __construct() {

        //create owode instance
        $this->owodeService = new owodeService();        
    }

    public function getowodePaymentData() {

        //get owode payment request data
        $owodeData = $this->owodeService->processIpnRequest();
        
        //return response data
        return $owodeData;
    }

}

