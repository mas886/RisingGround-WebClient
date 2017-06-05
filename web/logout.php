<?php

    function deleteCookies(){
        setcookie("token", "", time() - 3600, "/");
        setcookie("character", "", time() - 3600, "/");
    }

    if (isset($_GET['redirect'])){
        setcookie("token", "", time() - 3600, "/");
        setcookie("character", "", time() - 3600, "/");
        setcookie("user", "", time() - 3600, "/");
        header('Location: '."./login.php");
    }
