<?php

    include_once("config.php");

    function getItems($token){
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,"/shop/getarticles"),true);
        return $returnedArray['Message'];
    }
    
    function buyItemGold($articleId, $characterName, $token, $amount){
        $data = array('token' => $token, 'articleId' => $articleId, 'characterName' =>$characterName, 'amount'=>$amount);
        $returnedArray=json_decode(makeApiRequest($data,"/shop/buyarticlegold"),true);
        return $returnedArray['Message'];
    }

    function buyItemGems($articleId, $characterName, $token, $amount){
        $data = array('token' => $token, 'articleId' => $articleId, 'characterName' =>$characterName, 'amount'=>$amount);
        $returnedArray=json_decode(makeApiRequest($data,"/shop/buyarticlegems"),true);
        return $returnedArray['Message'];
    }
