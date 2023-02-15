<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;

class Sms
{

    private $username;
    private $password;
    private $customerId;
    private $sendertext;

    public function __construct()
    {
        $this->setConfig();
    }

    public function getConfig()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'customerId' => $this->customerId,
            'sendertext' => $this->sendertext,
        ];
    }

    public function username()
    {
        return $this->username;
    }

    public function key()
    {
        return $this->password;
    }

    public function setConfig()
    {
        $this->username = config("payment.username");
        $this->password = config("payment.password");
        $this->customerId = config("payment.customerId");
        $this->sendertext = config("payment.sendertext");
    }
}
