<!DOCTYPE html>
<?php
    require_once 'utility/db.php';

    session_start();

    if(isset($_SESSION['picture_id'])){
        $picture_id = $_SESSION['picture_id'];
        unset($_SESSION['picture_id']);
        increaseVoteCount($picture_id);
    }

    $sql = "select artists.photo as photo, pictures.id as id, pictures.name as pname, pictures.description_1 as desc1, 
            pictures.description_2 as desc2, pictures.path as path, pictures.votes as votes from artists left join pictures 
            on artists.id = pictures.artist_id where pictures.pending_status = 1 order by votes desc";
    $result = selectQuery($sql);

    if ($result->num_rows > 0) {
        $data_arr = array();
        while($row = $result->fetch_assoc()) {
            $data_arr[] = $row;
        }
    }

    $length = sizeof($data_arr);
    //print_r($data_arr);
    //print_r($length);
?>
<html lang="en">
    <head>
        <!-- Title -->
        <title>Home Page</title>
        
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
            <main class="mn-inner">
                <div class="card card-transparent no-m">
                <div class="card-content">
                        <div class="row">
                            <div class="col s12 m6 l3">
                                <?php for($i = 0; $i < $length; $i = $i + 4){ ?>
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <?php if($data_arr[$i]["photo"] === NULL){ ?>
                                                <img src="assets/images/male.png" class="circle responsive-img">
                                                <?php }else{ ?>
                                                <img src="<?php echo $data_arr[$i]["photo"]; ?>" class="circle responsive-img">
                                                <?php } ?>
                                            </div>
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s2">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action">
                                        <a class="waves-effect waves-light btn green m-b-xs" href="detail.php?id=<?php echo $data_arr[$i]["id"]; ?>">Read More...</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 1; $i < $length; $i = $i + 4){ ?>
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <?php if($data_arr[$i]["photo"] === NULL){ ?>
                                                <img src="assets/images/male.png" class="circle responsive-img">
                                                <?php }else{ ?>
                                                <img src="<?php echo $data_arr[$i]["photo"]; ?>" class="circle responsive-img">
                                                <?php } ?>
                                            </div>
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s2">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action">
                                        <a class="waves-effect waves-light btn green m-b-xs" href="detail.php?id=<?php echo $data_arr[$i]["id"]; ?>">Read More...</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 2; $i < $length; $i = $i + 4){ ?>
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <?php if($data_arr[$i]["photo"] === NULL){ ?>
                                                <img src="assets/images/male.png" class="circle responsive-img">
                                                <?php }else{ ?>
                                                <img src="<?php echo $data_arr[$i]["photo"]; ?>" class="circle responsive-img">
                                                <?php } ?>
                                            </div>
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s2">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action">
                                        <a class="waves-effect waves-light btn green m-b-xs" href="detail.php?id=<?php echo $data_arr[$i]["id"]; ?>">Read More...</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col s12 m6 l3">
                                <?php for($i = 3; $i < $length; $i = $i + 4){ ?>
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="<?php echo $data_arr[$i]['path']."/".$data_arr[$i]['pname']; ?>" alt="<?php echo $data_arr[$i]['pname']; ?>">
                                        <span class="card-title"><i class="material-icons left">thumb_up</i></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <?php if($data_arr[$i]["photo"] === NULL){ ?>
                                                <img src="assets/images/male.png" class="circle responsive-img">
                                                <?php }else{ ?>
                                                <img src="<?php echo $data_arr[$i]["photo"]; ?>" class="circle responsive-img">
                                                <?php } ?>
                                            </div>
                                            <div class="col s8">
                                                <span class="span-description-1" style="color:red"><?php echo $data_arr[$i]["desc1"]; ?></span>
                                            </div>
                                            <div class="col s2">
                                                <span><?php echo $data_arr[$i]["votes"]; ?> Votes</span>
                                            </div>
                                        </div>
                                        <span class="span-description-2"><?php echo $data_arr[$i]["desc2"]; ?></span>
                                    </div>
                                    <div class="card-action">
                                        <a class="waves-effect waves-light btn green m-b-xs" href="detail.php?id=<?php echo $data_arr[$i]["id"]; ?>">Read More...</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
    </body>
</html>