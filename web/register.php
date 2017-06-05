<?php

//Prevent multiple redirectionsif the token cookie is not set
$alreadyInLogin=true;

if (isset($_POST['email'])&&isset($_POST['username'])&&isset($_POST['password'])) {
    include_once("./controller/registerController.php");
    $apiResult=addNewUser($_POST['email'], $_POST['username'], $_POST['password']);
    if($apiResult==1){
        header('Location: '.'./login.php?register=success');
    }
}

include("./default_header.php");
?>
  <body class="login">
  
  <div class="background-image"></div>
    <div class="contentLogin">
        <h1 class="LoginCenter">Register</h1>
        <a type="button" class="btn btn-primary" href="./login.php">Sign In</a>
        <?php if(isset($apiResult)){ echo '<font color="red">'.$apiResult.'</font><br/>';} ?>
        <br/>
         <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                <input required name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                <input required type="text" name="username" class="form-control" id="inputEmail3" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                <input required type="password" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Repeat Password</label>
                <div class="col-sm-10">
                <input required type="password" id="confirm_password" name="repeatPassword" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                    <input required type="checkbox"> I accept the terms and conditions
                    </label>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign up</button>
                </div>
            </div>
        </form>
    </div>
  </body>
  
  <script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
  </script>
  
  
<?php
include("./default_footer.php");
?>
