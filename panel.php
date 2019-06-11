<?php
    require_once 'utility/db.php';

    session_start();

    //$dir = "E:/vote/test";
    $dir = "h:/root/home/openreward-003/www/site1/upload";

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    

    if(!isset($_SESSION['artist_id']) || !isset($_SESSION['artist_email'])){
        header("Location: login.php");
        exit();
    }

    if(isset($_POST['deleteResult'])){
        $delete_picture_id = $_POST['delete_pid'];
        $delete_picture = $_POST['delete_pname'];
        $delete_file = $_SERVER['DOCUMENT_ROOT'] . "/upload/" . $delete_picture;
        //$delete_file = $_SERVER['DOCUMENT_ROOT'] . "/vote/upload/" . $delete_picture;
        if(file_exists($delete_file)){
            unlink($delete_file);
            $sql = "delete from pictures where id = ".$delete_picture_id;
            $result = deleteQuery($sql);
        }
    }

    if(isset($_POST['editResult'])){
        $edit_picture_id = $_POST['edit_pid'];
        $edit_desc1 = $_POST['edit_desc1'];
        $edit_desc2 = $_POST['edit_desc2'];
        $sql = "update pictures set description_1 = '".$edit_desc1."', description_2 = '".$edit_desc2."' where id = ".$edit_picture_id;
        $result = updateQuery($sql);
    }

    if(isset($_POST['addResult'])){
            $target_path = $_SERVER['DOCUMENT_ROOT'] . "/upload/" . basename($_FILES['image']['name']);
            //$target_path = $_SERVER['DOCUMENT_ROOT'] . "/vote/upload/" . basename($_FILES['image']['name']);
            //print_r($target_path);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_path);

            $image = basename($_FILES['image']['name']);
            $add_desc1 = $_POST['add_desc1'];
            $add_desc2 = $_POST['add_desc2'];
            $aid = $_POST['aid'];

            $sql = 'insert into pictures (artist_id, name, description_1, description_2, path, pending_status, votes) 
                    values ('.$aid.', "'.$image.'", "'.$add_desc1.'", "'.$add_desc2.'", "upload", 0, 0)';

            $result = insertQuery($sql);
            if($result != "success"){
                echo "insert statement error.......";
                exit();
            }
    }

    $artist_id = $_SESSION['artist_id'];
    $artist_name = $_SESSION['artist_name'];
    $artist_email = $_SESSION['artist_email'];
    $artist_picture = $_SESSION['artist_picture'];

    $check_sql = 'select * from artists where email = "'.$artist_email.'"';
    $check_result = selectQuery($check_sql);

    if($check_result->num_rows <= 0){
        $insert_sql = 'insert into artists (email, name, photo, register_date) values ("'.$artist_email.'", "'.$artist_name.'", "'.$artist_picture.'", NOW())';
        $insert_result = insertQuery($insert_sql);
        if($insert_result != "success"){
            echo "insert statement error.......";
            exit();
        }
    }

    $sql = 'select artists.id as aid, artists.photo as photo, artists.name as aname, pictures.id as id, pictures.name as pname, pictures.description_1 as desc1, 
        pictures.description_2 as desc2, pictures.path as path, pictures.pending_status as status, pictures.votes as votes from artists left join pictures 
        on artists.id = pictures.artist_id where artists.email = "'.$artist_email.'"';
    $result = selectQuery($sql);

    if ($result->num_rows > 0) {
        $data_arr = array();
        while($row = $result->fetch_assoc()) {
            $data_arr[] = $row;
        }
    }

    $length = sizeof($data_arr);
?>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Control Panel Page</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="search-app quick-results-off">
        <div class="mn-content">
            <header class="mn-header navbar-fixed">
            
                <nav class="cyan darken-1">
                    <div class="nav-wrapper row">
                        <ul class="right col s3 m3 nav-right-menu">
                            <li><a href="javascript:void(0)" data-activates="chat-sidebar" class="chat-button show-on-large"><i class="material-icons">more_vert</i></a></li>
                        </ul>
                        <div class="header-title col s9">      
                            <span class="chapter-title">Welcome</span>
                        </div>
                    </div>
                </nav>
            </header>
            <aside id="chat-sidebar" class="side-nav white right-aligned" style="transform: translateX(0px);">
                <div class="side-nav-wrapper">
                    <div class="col s12">
                        <ul class="tabs tab-demo" style="width: 100%;">
                            <li class="tab col s3"><a href="#sidebar-chat-tab" class="active"><?php echo $data_arr[0]["aname"]; ?></a></li>
                        <div class="indicator" style="right: 110px; left: 0px;"></div></ul>
                    </div>
                    <div id="sidebar-chat-tab" class="col s12 sidebar-messages right-sidebar-panel">
                        <div class="chat-list">
                            <a href="#" id="logout" class="chat-message">
                                <div class="chat-item">
                                    <div class="chat-item-info">
                                        <p class="chat-name">Logout</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#add-modal" class="chat-message modal-trigger">
                                <div class="chat-item">
                                    <div class="chat-item-info">
                                        <p class="chat-name">ArtWork</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
            <main class="mn-inner">
                <div class="card card-transparent no-m">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m6 l3">
                                <?php for($i = 0; $i < $length; $i = $i + 4){ ?>
                                <div id="<?php echo $data_arr[$i]["id"]; ?>" class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <?php if($data_arr[$i]["status"] == 1){ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                        <?php }else{ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_down</i></span>
                                        <?php } ?>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s4">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action right-align">
                                        <a class="a-delete waves-effect waves-light btn green m-b-xs modal-trigger" href="#delete-modal">Delete</a>
                                        <a class="a-edit waves-effect waves-light btn green m-b-xs modal-trigger" href="#edit-modal">Edit</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 1; $i < $length; $i = $i + 4){ ?>
                                <div id="<?php echo $data_arr[$i]["id"]; ?>" class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <?php if($data_arr[$i]["status"] == 1){ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                        <?php }else{ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_down</i></span>
                                        <?php } ?>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s4">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action right-align">
                                        <a class="a-delete waves-effect waves-light btn green m-b-xs modal-trigger" href="#delete-modal">Delete</a>
                                        <a class="a-edit waves-effect waves-light btn green m-b-xs modal-trigger" href="#edit-modal">Edit</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 2; $i < $length; $i = $i + 4){ ?>
                                <div id="<?php echo $data_arr[$i]["id"]; ?>" class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <?php if($data_arr[$i]["status"] == 1){ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                        <?php }else{ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_down</i></span>
                                        <?php } ?>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s4">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action right-align">
                                        <a class="a-delete waves-effect waves-light btn green m-b-xs modal-trigger" href="#delete-modal">Delete</a>
                                        <a class="a-edit waves-effect waves-light btn green m-b-xs modal-trigger" href="#edit-modal">Edit</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 3; $i < $length; $i = $i + 4){ ?>
                                <div id="<?php echo $data_arr[$i]["id"]; ?>" class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <?php if($data_arr[$i]["status"] == 1){ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                        <?php }else{ ?>
                                        <span class="card-title"><i class="material-icons left">thumb_down</i></span>
                                        <?php } ?>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s4">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action right-align">
                                        <a class="a-delete waves-effect waves-light btn green m-b-xs modal-trigger" href="#delete-modal">Delete</a>
                                        <a class="a-edit waves-effect waves-light btn green m-b-xs modal-trigger" href="#edit-modal">Edit</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="delete-modal" class="modal">
            <form action="" method="post">
                <div class="modal-content">
                    <h4>Note</h4>
                    <p>Do you want to delete this picture?</p>
                </div>
                <div class="modal-footer">
                    <a class="modal-action modal-close waves-effect waves-green btn-flat">No</a>
                    <input type="hidden" id="input-delete-pid" name="delete_pid">
                    <input type="hidden" id="input-delete-pname" name="delete_pname">
                    <input type="submit" class="modal-action modal-close btn-flat waves-green" name="deleteResult" value="Yes">
                </div>
            </form>
        </div>

        <div id="edit-modal" class="modal modal-fixed-footer">
            <form action="" method="post">
                <div class="modal-content">
                    <br><h4>Editor</h4><br>
                    <div class="input-field col s6">
                        <br><input id="input-description-1" type="text" name="edit_desc1" class="validate">
                        <label for="description_1" class="">Description 1</label>
                    </div>
                    <br><br>
                    <div class="input-field col s12">
                        <br><textarea id="textarea-description-2" name="edit_desc2" class="materialize-textarea" length="250"></textarea>
                        <label for="description_2" class="">Description 2</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <input type="hidden" id="input-edit-pid" name="edit_pid">
                    <input type="submit" class="modal-action modal-close btn-flat waves-green" name="editResult" value="Save">
                </div>
            </form>
        </div>

        <div id="add-modal" class="modal modal-fixed-footer">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <br><h4>ArtWork</h4><br>
                    <div id="extension-invalid"></div>
                    <div class="col s12 file-field input-field">
                        <div class="btn teal lighten-1">
                            <span>Picture</span>
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <br><input type="text" name="add_desc1" class="validate">
                        <label for="description_1" class="">Description 1</label>
                    </div>
                    <br><br>
                    <div class="input-field col s12">
                        <br><textarea name="add_desc2" class="materialize-textarea" length="250"></textarea>
                        <label for="description_2" class="">Description 2</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aid" value="<?php echo $data_arr[0]['aid']; ?>">
                    <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <input type="submit" id="input-add" class="modal-action btn-flat waves-green" name="addResult" value="Add">
                </div>
            </form>
        </div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script>
            var del_div, edit_div, description_1_span, description_2_span, edit_pid, delete_pid, delete_pname;
            $('.a-delete').on('click', function(e){
                del_div = $(this).parent().parent();
                delete_pname = $(this).parent().parent().find('img').attr('alt');
                delete_pid = del_div.attr('id');
                $('#input-delete-pid').val(delete_pid);
                $('#input-delete-pname').val(delete_pname);
            });
            
            $('.a-edit').on('click', function(e){
                edit_div = $(this).parent().parent();
                description_1_span = $(this).parent().parent().find('span.span-description-1');
                description_2_span = $(this).parent().parent().find('span.span-description-2');
                edit_pid = edit_div.attr('id');
                $('#input-description-1').val(description_1_span.text());
                $('#textarea-description-2').val(description_2_span.text());
                $('#input-edit-pid').val(edit_pid);
            });

            $('#input-add').click(function(e){
                var image_name = $('#image').val();
                if(image_name == ''){
                    document.getElementById('extension-invalid').innerHTML = '<div class="chip">Please Select Image!<i class="close material-icons">close</i></div>';
                    return false;
                }
                else{
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                        document.getElementById('extension-invalid').innerHTML = '<div class="chip">Invalid Image File!<i class="close material-icons">close</i></div>';
                        return false;
                    }
                }
            });
        </script>
        <script>
            $('#logout').click(function(e){
                FB.getLoginStatus(function(response) 
                {
                    if (response.status === 'connected') 
                    {
                        var accessToken = response.authResponse.accessToken;
                        //console.log(accessToken);
                        if(accessToken)
                        {
                            FB.logout(function(response){
                                //FB.Auth.setAuthResponse(null, 'unknown');
                                //document.location.reload();
                                window.location = "login.php";
                            });
                        }
                    } 
                });
            });
          
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