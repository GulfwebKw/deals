<?php

namespace App\payment\Models;

/**
 * This class contains all parameters of payment response
 *
 * @author Hesabe
 */
class HesabePaymentResponseModel
{
    public $resultCode;
    public $amount;
    public $variable1;
    public $variable2;
    public $variable3;
    public $paymentToken;
    public $paymentId;
    public $paidOn;
    public $orderReferenceNumber;
    public $method;
    public $administrativeCharge;

    /**
     * Return the default properties of the class.
     *
     * @return array class properties
     */
    public function getVariables()
    {
        return get_object_vars($this);
    }
}
