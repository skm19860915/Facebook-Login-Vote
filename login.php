<!DOCTYPE html>
<?php
    session_start();

    if(isset($_SESSION['artist_id'])){
        unset($_SESSION['artist_id']);
        unset($_SESSION['artist_name']);
        unset($_SESSION['artist_email']);
        unset($_SESSION['artist_picture']);
    }

    if(isset($_POST['artist_id'])){
        $_SESSION['artist_id'] = $_POST['artist_id'];
        $_SESSION['artist_name'] = $_POST['artist_name'];
        $_SESSION['artist_email'] = $_POST['artist_email'];
        $_SESSION['artist_picture'] = $_POST['artist_picture'];
        exit("success");
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
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="signin-page mn-content valign-wrapper">
            <main class="mn-inner container">
                <div class="valign">
                    <div class="row">
                        <div class="col s12 m6 l4 offset-l4 offset-m3">
                            <div class="card white darken-1">
                                <div class="card-content ">
                                    <span class="card-title">Log In</span>
                                    <div class="row">
                                        <div class="col s12 center-align">
                                            <div onlogin="artistLogin();" class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                            <a onclick="test();" class="waves-effect waves-light btn green m-b-xs">Test</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <div id="fb-root"></div>
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script>
            var artist = {artist_id: "", artist_name: "", artist_email: "", artist_picture: ""};

            function artistLogin()
            {
                FB.login(function(response) {
                    if (response.authResponse) 
                    {
                        var access_token =   FB.getAuthResponse()['accessToken'];
                        FB.api('/me', {fields: 'id,name,email,picture'}, function(response) {
                            artist.artist_id = response.id;
                            artist.artist_name = response.name;
                            artist.artist_email = response.email;
                            artist.artist_picture = response.picture.data.url;
                            console.log(response);

                            $.ajax({
                                url: 'login.php',
                                method: 'POST',
                                data: artist,
                                datatype: 'text',
                                success: function(serverResponse){
                                    window.location = "panel.php";
                                }
                            });
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: ''});
            }

            function test()
            {
                console.log("test..........");
                artist.artist_id = 4;
                artist.artist_name = "Michael Zhang";
                artist.artist_email = "michael@gmail.com";
                artist.artist_picture = null;

                $.ajax({
                    url: 'login.php',
                    method: 'POST',
                    data: artist,
                    datatype: 'text',
                    success: function(serverResponse){
                        window.location = "panel.php";
                    }
                });
            }

            window.fbAsyncInit = function() {
                FB.init({
                appId            : '{appid}',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.3'
                });
            };
        </script>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
    </body>
</html>