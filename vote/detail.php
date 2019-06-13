<!DOCTYPE html>
<?php
    require_once 'utility/db.php';

    session_start();

    if(isset($_POST['picture_id'])){
        $_SESSION['picture_id'] = $_POST['picture_id'];
        exit("success");
    }

    $pid = $_GET['id'];

    $sql = "select artists.photo as photo, pictures.id as id, pictures.name as pname, pictures.description_1 as desc1, 
            pictures.description_2 as desc2, pictures.path as path, pictures.votes as votes from artists left join pictures 
            on artists.id = pictures.artist_id where pictures.id = ".$pid;
    $result = selectQuery($sql);

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
    }
?>

<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Detail Page</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>

        <meta property="og:url"           content="https://artcontest.agapepapa.com/detail.php" />
        <meta property="og:type"          content="https://artcontest.agapepapa.com" />
        <meta property="og:title"         content="vote" />
        <meta property="og:description"   content="detail page" />
        <meta property="og:image"         content="https://artcontest.agapepapa.com/path/image.jpg" />
    </head>
    <body class="search-app quick-results-off">
        <div class="mn-content">
            <main class="mn-inner">
                <div class="card card-transparent no-m">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m1 l2"></div>
                            <div class="col s12 m10 l8">
                                <div class="card">
                                    <div class="card-image">
                                        <img src="<?php echo $record["path"].'/'.$record["pname"];?>" alt="">
                                        <span class="card-title"><i class="material-icons dp48">thumb_up</i></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                            <?php
                                            if($record["photo"] === NULL)
                                            {
                                                echo '<img src="assets/images/male.png" alt="" class="circle responsive-img">';
                                            }
                                            else
                                            {
                                                echo '<img src="'.$record["photo"].'" alt="" class="circle responsive-img">';
                                            }
                                            ?>
                                            </div>
                                            <div class="col s8">
                                                <span style="color:red"><?php echo $record["desc1"];?></span>
                                            </div>
                                            <div class="col s2">
                                                <span><?php echo $record["votes"];?> Votes</span>
                                            </div>
                                        </div>
                                        <span><?php echo $record["desc2"];?></span>
                                    </div>
                                    <div class="card-action">
                                        <div id="login-div" style="display:none;">
                                            <span>Do you want to vote? Please click FB Login to login first.&nbsp;&nbsp;</span>
                                            <div onlogin="userLogin();" class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                        </div>    
                                        <div id="vote-div" style="display:none;">
                                            <a class="waves-effect waves-light btn green m-b-xs disabled" onclick="goFirstPage(<?php echo $record['id']; ?>)">Vote + 1</a>
                                            <div class="fb-like" data-href="https://artcontest.agapepapa.com/detail.php?id=<?php echo $pid; ?>" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m1 l2"></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script>
            var user = {userid: "", username: "", useremail: ""};
            var picture_data = {picture_id: ""};

            function goFirstPage(value)
            {
                var isDisabled = $("#vote-div a").hasClass("disabled");
                if(isDisabled){
                    console.log("disabled.............");
                }
                else{
                    picture_data.picture_id = value;

                    $.ajax({
                        url: 'detail.php?id=' + value,
                        method: 'POST',
                        data: picture_data,
                        datatype: 'text',
                        success: function(serverResponse){
                            window.location = "/";
                        }
                    });
                }
            }

            function userLogin()
            {
                FB.login(function(response) {
                    if (response.authResponse) 
                    {
                        var access_token =   FB.getAuthResponse()['accessToken'];
                        console.log('Access Token = '+ access_token);
                        FB.api('/me', {fields: 'id,name,email,picture'}, function(data) {
                            user.username = data.name;
                            user.userid = data.id;
                            console.log(data);

                            $("#vote-div").css("display", "block");
                            $("#login-div").css("display", "none");
                            sessionStorage.setItem("user_id", data.id);
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: ''});
            }

            window.fbAsyncInit = function() {

                if(sessionStorage.getItem("user_id")){
                    console.log("found");
                    $("#vote-div").css("display", "block");
                    $("#login-div").css("display", "none");
                }
                else{
                    console.log("not found");
                    $("#vote-div").css("display", "none");
                    $("#login-div").css("display", "block");
                }

                FB.init({
                appId            : '{appid}',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.3'
                });

                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') 
                    {
                        var uid = response.authResponse.userID;
                        var accessToken = response.authResponse.accessToken;
                        console.log("+++++" + accessToken);
                    } 
                    else if (response.status === 'not_authorized') 
                    {
                        console.log("--------------");
                    } 
                    else 
                    {
                        // The user isn't logged in to Facebook. You can launch a
                        // login dialog with a user gesture, but the user may have
                        // to log in to Facebook before authorizing your application.
                        console.log("very bad.......");
                    }
                });

                FB.Event.subscribe('edge.create', function(response) {
                    console.log('thank you.......');
                    $("#vote-div a").removeClass("disabled");
                });
        };
        </script>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
    </body>
</html>


