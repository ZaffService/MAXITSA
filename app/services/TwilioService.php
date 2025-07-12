<?php

class TwilioService
{
    public function sendSms(string $to, string $message): bool
    {
        $data = [
            'From' => TWILIO_FROM,
            'To' => $to,
            'Body' => $message
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/" . TWILIO_SID . "/Messages.json",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_USERPWD => TWILIO_SID . ':' . TWILIO_TOKEN,
            CURLOPT_RETURNTRANSFER => true
        ]);
        
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result !== false;
    }
}
