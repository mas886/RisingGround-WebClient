<?php
$_POST = array();
//Prevent multiple redirectionsif the token cookie is not set
$alreadyInLogin=true;

include("./default_header.php");

?>
  <body class="login">
  
  <div class="background-image"></div>
    <div class="contentLogin">
        <h1 class="LoginCenter">Login</h1>
        <a type="button" class="btn btn-primary" href="./register.php">Sign Up</a>
        <?php if(isset($_GET['register'])){ ?>
            <br/>
            <br/>
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Signed up correctly!</strong> Now, login to enter game.
            </div>
        <?php }else if(isset($_GET['sessionEnd'])){ ?>
            <br/>
            <br/>
            <div class="alert alert-warning alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Session Ended!</strong> Please, login back to the game.
            </div>
        <?php 
        }else{
            echo "<br/><br/>";
        }
        ?>
        <?php
            if(isset($_GET['mes'])){
                echo '<font color="red">'.$_GET['mes'].'</font><br/>';;
            }
        ?>
        <div>
         <form class="form-horizontal" action="./controller/loginController.php" method="POST">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                <input  name="username" required type="text" class="form-control" id="inputEmail3" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                <input name="password"  required type="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                    <input type="checkbox"> Remember me
                    </label>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
                </div>
            </div>
        </form>
        </div>
    </div>
  </body>
  
  
<?php
include("./default_footer.php");
?>
