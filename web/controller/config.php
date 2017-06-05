<?php
    
    function makeApiRequest($data,$path){
    
        $apiUrl="http://pathtoapi/index.php";
    
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($apiUrl.$path, false, $context);
    if ($result === FALSE) { return "Api request error."; }

    return($result);
    }
    
    
