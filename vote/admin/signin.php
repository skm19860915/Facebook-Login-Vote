<!DOCTYPE html>
<?php
    require_once '../utility/db.php';

    session_start();

    if(isset($_SESSION['signedin'])){
        unset($_SESSION['signedin']);
        unset($_SESSION['username']);
    }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $language = $_POST['language'];

        $password = md5($password);
        $sql = "select * from users where username = '$username' and password = '$password'";
        $result = selectQuery($sql);

        if($result->num_rows > 0){
            $_SESSION['signedin'] = 1;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['language'] = $language;
            header("Location: dashboard.php");
        }else{
            print_r("error...........");
        }
    }
?>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Login Page</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="signin-page mn-content valign-wrapper">
            <main class="mn-inner container">
                <div class="valign">
                    <div class="row">
                        <div class="col s12 m6 l4 offset-l4 offset-m3">
                            <div class="card white darken-1">
                                <div class="card-content ">
                                    <span class="card-title">Sign In</span>
                                    <div class="row">
                                        <form class="col s12" action="" method="post" accept-charset="UTF-8">
                                            <div class="input-field col s12">
                                                <input id="username" type="text" name="username" class="validate">
                                                <label for="name">Name</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input id="password" type="password" name="password" class="validate">
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="col s12 right-align m-t-sm">
                                                <select class="browser-default col s6" name="language">
                                                    <option value="1">English</option>
                                                    <option value="2">Chinese</option>
                                                </select>
                                                <input type="submit" class="waves-effect waves-light btn teal" value="sign in" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script>
            $("select").change(function (){
                console.log($('select :selected').val());
            }); 
        </script>
    </body>
</html>