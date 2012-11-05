<?php

class ducksboardPush {
    public $errno = 0;
    public $errordesc = "";

    private $_widget_label = "";
    private $_payload = "";

    public function ducksboardPush($label, $data) {
        $this->_widget_URL = "https://push.ducksboard.com/values/".$label."/";
        $this->_payload = json_encode($data);
        Log::e("Duckbsboard URL: ".$this->_widget_URL,Log::DEBUG_FLAG);
        Log::e("Duckbsboard Payload: ".$this->_payload,Log::DEBUG_FLAG);

        $ch = curl_init($this->_widget_URL);
        curl_setopt($ch, CURLOPT_USERPWD, API_KEY . ":x"); 
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $this->_payload);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        $this->errno = curl_errno($ch);
        $this->errordesc = curl_errno($ch);
        curl_close ($ch);
    }
}

/* Using CURL from CLI
$return_message_array="";
$return_number="";
$str = '{"value": '.$results.'}';
$curly = "/usr/bin/curl -v -u ".API_KEY.":x -d '".$str."' https://push.ducksboard.com/v/87980";
exec( $curly, $return_message_array, $return_number );  
echo "Return msg [$return_message_array] Return #[$return_number]\n";
*/


//$gc = new ducksboardPush("41142", array('value'=>"510"));