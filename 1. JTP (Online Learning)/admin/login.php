<?php 
	session_start();
	if(isset($_SESSION['user_name']) && $_SESSION['user_name']!=""){
        echo
        '<script language="javascript">
        alert("Hey '.$_SESSION['user_name'].',\nPlease Logout First!");
        window.location.href="index.php?sessionActive=true"
        </script>';
    }
    else if (isset($_POST['submit'])){
        $login = $_POST['login'];
        $pwd = base64_encode($_POST['pwd']);
        if (filter_var($login, FILTER_VALIDATE_EMAIL)){
            $loginQuery = "SELECT * FROM `users` WHERE `email`='$login' && `pwd`='$pwd'";
        }
        else {
            $loginQuery = "SELECT * FROM `users` WHERE `uname`='$login' && `pwd`='$pwd'";
        }
        require_once('config.php');
        $result = mysqli_query($conn, $loginQuery);
        if (mysqli_num_rows($result) == 1){
            while ($res = mysqli_fetch_assoc($result)){
                $_SESSION['user_name']=$res['uname'];
                $_SESSION['fname']=$res['fname'];
                header('Location: index.php');
            }
        }
        else {
            echo
            '<script language="javascript">
            alert("Invalid Credentials! Try Again!");
            window.location.href="login.php"
            </script>';
          }
    }
    else {
?>
        <!doctype html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, intial-scale=1.0">
                <title>JTP BackEnd | Login Page</title>
                <link href="assets/css/bootstrap.min.css" rel="stylesheet">
                <link href="assets/css/style.css" rel="stylesheet">
                <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
                <script src="assets/js/jquery.min.js"></script>
                <style>
                    body {
                        background-color: rgba(0,0,0,0.8);
                    }
                    .fa.fa-user-circle-o,
                    .fa.fa-eye,
                    .fa.fa-eye-slash {
                        font-size: 24px;
                    }
                </style>
            </head>
            <body>
                <section id="login" class="mt-5 pt-5 container">
                    <div class="card rounded-top px-0 mybgcolor text-light shadow col-md-4 offset-md-4">
                        <h1 class="text-center py-2 border-bottom">LOGIN<br></h1>
                        <form action="login.php" method="POST">
                            <div class="pt-3 form-group col-md-10 offset-md-1">
                                <label for="login">LOGIN:</label>
                                <div class="input-group">
									<div class="input-group-prepend">
										<span class="bg-light input-group-text" id="basic-addon1"><i class="text-dark fa fa-user-circle-o"></i></span>
									</div>
                                    <input class="bg-light text-dark form-control" type="text" name="login" required placeholder="Enter username or email ID">
                                </div>
                                <label class="pt-3" for="login">PASSWORD:</label>
                                <div class="input-group">
									<div class="input-group-prepend">
										<span class="bg-light input-group-text" id="basic-addon2"><i id="pwd_toggle" class="text-dark fa fa-eye"></i></span>
									</div>
                                <input class="bg-light text-dark form-control" id="pwd" type="password" name="pwd" required placeholder="Enter password">
                            </div> 
                            <p class="text-warning text-center">Click on the eye to unhide password</p>
                            <div class="form-row py-3 justify-content-center my-3">
                                <button class="btn btn-info col-md-8" type="submit" name="submit">LOGIN</button>
                                <a class="my-3 text-danger" href="register.php">New here? Click here to Register!</a>
                            </div>
                        </form>
                    </div>
                </section>
                <script>
                    $(document).ready(function(){
                        $('p').hide();
                        $('#pwd').focus(function(){
                            $('p').fadeIn('fast','linear');
                        }).blur(function() {
                            $('p').fadeOut('fast','linear');
                        });
                        $('*:not(#pwd)').focus(function (){
                            $('p').fadeOut('fast','linear');
                        });
                        $('#pwd_toggle').click(function (){
                            $(this).attr('class', function(val, attr) {
                                return attr == 'text-dark fa fa-eye' ? 'text-dark fa fa-eye-slash' : 'text-dark fa fa-eye';
                            });
                            $('#pwd').attr('type', function (curr, attr){
                                return attr == 'password' ? 'text' : 'password';
                            }).attr('class', function (curr, attr){
                                return attr == 'bg-light text-dark form-control' ? 'bg-light text-dark form-control' : 'bg-light text-dark form-control';
                            });
                            $('p').text(function(curr, text){
                                return text == 'Click on the eye to hide password' ? 'Click on the eye to unhide password' : 'Click on the eye to hide password';
                            }).attr('class', function(curr, attr){
                                return attr == 'text-warning text-center' ? 'text-danger text-center' : 'text-warning text-center';  
                            }).fadeIn();
                        });
                    });
                </script>
            </body>
        </html>
<?php }
?>