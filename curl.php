<?php

class curl {
    public function get($Url, $Token){
        $ch = curl_init($Url);    
         if ($ch  === FALSE) throw new Exception('failed to initialize');
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: php-curl",
             "Authorization: token ".$Token,
             "Content-Length: 0"));
         $Content = curl_exec($ch);
         
         if ($Content === FALSE) throw new Exception(curl_error($ch), curl_errno($ch));
         return $Content;
    }
}
?>