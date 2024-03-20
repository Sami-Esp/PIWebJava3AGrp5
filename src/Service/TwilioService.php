<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'ACd82cdacc751fa8a1b33c30c6f370b5ba';
    private $authToken = '88ceb1675b444aca0f98857c871af667';
    private $twilioPhoneNumber = '+12694480709';
   
    public function sendSMS()
    {
        $to = '+21629835571'; // Le numéro de téléphone destinataire
        $message = 'un don a eté effetué avec succée'; // Le message que vous souhaitez envoyer
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $message,
            ]
        );
    }
}