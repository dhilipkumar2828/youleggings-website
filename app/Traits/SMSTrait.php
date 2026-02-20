<?php

namespace App\Traits;

trait SMSTrait {

    /*

    This will send test message to a given number or comma seperated numbers.

    $to_number: Integer. A single numnber Or String: comma seperated numbers.

    $templateid: String: Template id which has been created in textspeed portal.

    $message_content: Text: Content which is to be sent.

    $response: Success or Failure along with the error message returned by TextSpeed.

    */

    public function sendSms($to_number, $templateid, $message_content) {

        $key = env('TEXTSPEED_API_KEY');

        $mbl = $to_number; 	/*or $mbl="XXXXXXXXXX,XXXXXXXXXX";*/

        $senderid = env('TEXTSPEED_SENDER_ID');

        $route= 1;

        $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$message_content";

        $output = file_get_contents($url);	/*default function for push any url*/

        return $output;

    }

}
