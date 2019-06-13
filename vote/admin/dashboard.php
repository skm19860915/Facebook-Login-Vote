<?php
    require_once '../utility/db.php';

    session_start();

    if(!isset($_SESSION['signedin']) || $_SESSION['signedin'] == 0){
        header("Location: signin.php");
        exit();
    }

    if(isset($_POST['picture_id'])){
        $picture_id = $_POST['picture_id'];
        $is_approved = $_POST['is_approved'];
        $sql = "update pictures set pending_status = ".$is_approved." where id = ".$picture_id;
        $result = updateQuery($sql);
        if($result == "success"){
            $data['id'] = $picture_id;
            $data['is_approved'] = $is_approved;
            $jsonData = json_encode($data);
            exit($jsonData);
        }
        else{
            exit(NULL);
        }
    }

    if(isset($_POST['del_picture_id'])){
        $del_picture_id = $_POST['del_picture_id'];
        $del_picture_name = $_POST['del_picture_name'];

        $delete_file = $_SERVER['DOCUMENT_ROOT'] . "/vote/upload/" . $del_picture_name;
        if(file_exists($delete_file)){
            unlink($delete_file);
            $sql = "delete from pictures where id = ".$del_picture_id;
            $result = deleteQuery($sql);
            if($result == "success"){
                exit($del_picture_id);
            }
            else{
                exit(NULL);
            }
        }
    }

    function getLanguageFile()
    {
        $language = $_SESSION['language'];
        $textFile = "en.txt";
        if($language == 2){
            $textFile = "cn.txt";
        }
        $file = fopen("../assets/language/".$textFile, "r") or die("Unable to open file!");
        $format_arr = array();
        while(!feof($file)){
            $line = fgets($file);
            $format_arr[] = explode('CRLF', $line);
        }
        fclose($file);

        return $format_arr;
    }

    $format_array = getLanguageFile();
    $data_array = getArtistListOfDb();
    //print_r($data_array);
?>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Admin Page</title>
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="mn-content">
            <header class="mn-header navbar-fixed">
                <nav class="cyan darken-1">
                    <div class="nav-wrapper row">
                        <div class="header-title col s3">      
                            <span class="chapter-title"><?php echo $format_array[0][0] ?></span>
                        </div>
                        <ul class="right col s9 m3 nav-right-menu">
                            <li>
                                <a href="index.php"><?php echo $format_array[1][0] ?></a>
                            </li>
                            <li>
                                <strong><?php echo $_SESSION['username'] ?></strong>
                            </li>     
                        </ul>
                    </div>
                </nav>
            </header>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <table id="example" class="display responsive-table datatable-example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $format_array[2][0] ?></th>
                                            <th><?php echo $format_array[3][0] ?></th>
                                            <th><?php echo $format_array[4][0] ?></th>
                                            <th><?php echo $format_array[5][0] ?></th>
                                            <th><?php echo $format_array[6][0] ?></th>
                                            <th><?php echo $format_array[7][0] ?></th>
                                            <th><?php echo $format_array[8][0] ?></th>
                                            <th><?php echo $format_array[9][0] ?></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th><?php echo $format_array[2][0] ?></th>
                                            <th><?php echo $format_array[3][0] ?></th>
                                            <th><?php echo $format_array[4][0] ?></th>
                                            <th><?php echo $format_array[5][0] ?></th>
                                            <th><?php echo $format_array[6][0] ?></th>
                                            <th><?php echo $format_array[7][0] ?></th>
                                            <th><?php echo $format_array[8][0] ?></th>
                                            <th><?php echo $format_array[9][0] ?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach($data_array as $item)
                                        {
                                            echo '<tr id="'.$item["pid"].'">';
                                                if($item["photo"] === NULL)
                                                {
                                                    echo '<td><img src="../assets/images/male.png" alt="" class="img-gender circle" style="width:20px;"></td>';
                                                }
                                                else
                                                {
                                                    echo '<td><img src="'.$item["photo"].'" alt="" class="img-gender circle" style="width:20px;"></td>';
                                                }
                                                echo '<td><span class="span-pname">'.$item["pname"].'</span></td>';
                                                echo '<td><span class="span-name">'.$item["name"].'</span></td>';
                                                echo '<td><span class="span-email">'.$item["email"].'</span></td>';
                                                echo '<td><span class="span-register-date">'.$item["register_date"].'</span></td>';
                                                if($item["status"] == 1)
                                                {
                                                    echo '<td><span class="span-status">Approved</span></td>';
                                                }
                                                else
                                                {
                                                    echo '<td><span class="span-status"><i>Rejected</i></span></td>';
                                                }
                                                echo '<td><a id="'.$item["pid"].'" style="margin-bottom:0px;" class="a-detail waves-effect waves-light btn green m-b-xs modal-trigger"
                                                     href="#detail-modal">'.$format_array[10][0].'</a></td>';
                                                echo '<td>
                                                        <a class="a-reject btn">'.$format_array[11][0].'</a>
                                                        <a class="a-approve btn">'.$format_array[12][0].'</a>
                                                        <a class="a-delete btn">'.$format_array[13][0].'</a>
                                                        <input type="hidden" class="input-desc1" value="'.$item["desc1"].'" />
                                                        <input type="hidden" class="input-desc2" value="'.$item["desc2"].'" />
                                                        <input type="hidden" class="input-path" value="../'.$item["path"].'/" />
                                                        <input type="hidden" class="input-votes" value="'.$item["votes"].'" />
                                                    </td>';
                                            echo '</tr>';  
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div id="detail-modal" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4><?php echo $format_array[14][0] ?></h4><br>
                <div class="chip">
                    <img id="modal-img-gender"><span id="modal-span-name"></span>
                </div>
                <div>
                    <p><?php echo $format_array[5][0] ?> : <span id="modal-span-email"></span></p>
                </div>
                <div>
                    <p><?php echo $format_array[6][0] ?> : <span id="modal-span-register-date"></span></p>
                </div>
                <div>
                    <p><?php echo $format_array[15][0] ?> : <span id="modal-span-votes"></span></p>
                </div>
                <div>
                    <p><?php echo $format_array[7][0] ?> : <span id="modal-span-status"></span></p>
                </div>
                <div>
                    <p><?php echo $format_array[16][0] ?> 1 : <span id="modal-span-desc1"></span></p>
                </div>
                <div>
                    <p><?php echo $format_array[16][0] ?> 2 : <span id="modal-span-desc2"></span></p>
                </div>
                <div>
                    <p><img id="modal-drawing-img" class="responsive-img" style="display:block; margin:0 auto;" ></p>
                </div>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect waves-green btn-flat"><?php echo $format_array[17][0] ?></a>
            </div>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/table-data.js"></script>
        <script>
            $('.a-detail').on('click', function(e){
                var gender = $(this).parent().parent().find('img.img-gender').attr('src');
                var name = $(this).parent().parent().find('span.span-name').text();
                var email = $(this).parent().parent().find('span.span-email').text();
                var register_date = $(this).parent().parent().find('span.span-register-date').text();
                var votes = $(this).parent().parent().find('input.input-votes').val();
                var status = $(this).parent().parent().find('span.span-status').text();
                var desc1 = $(this).parent().parent().find('input.input-desc1').val();
                var desc2 = $(this).parent().parent().find('input.input-desc2').val();

                var pname = $(this).parent().parent().find('span.span-pname').text();
                var path = $(this).parent().parent().find('input.input-path').val();
                var drawing_img = path + pname;

                $('#modal-span-name').text(name);
                $('#modal-img-gender').attr('src', gender);
                $('#modal-span-email').text(email);
                $('#modal-span-register-date').text(register_date);
                $('#modal-span-votes').text(votes);
                $('#modal-span-status').text(status);
                $('#modal-span-desc1').text(desc1);
                $('#modal-span-desc2').text(desc2);
                $('#modal-drawing-img').attr('src', drawing_img);
            });

            var reject_tr, approve_tr, delete_tr;
            $('.a-reject').on('click', function(e){
                reject_tr = $(this).parent().parent();
                var picture_id = reject_tr.attr('id');
                //console.log(picture_id);
                updateRecord(picture_id, 0);
            });

            $('.a-approve').on('click', function(e){
                approve_tr = $(this).parent().parent();
                var picture_id = approve_tr.attr('id');
                updateRecord(picture_id, 1);
            });

            $('.a-delete').on('click', function(e){
                delete_tr = $(this).parent().parent();
                var picture_id = delete_tr.attr('id');
                var picture_name = delete_tr.find('span.span-pname').text();
                deleteRecord(picture_id, picture_name);
            });

            function updateRecord(id, isApproved)
            {
              
                var data = {picture_id: id, is_approved: isApproved};

                $.ajax({
                    url: 'dashboard.php',
                    type: 'POST',
                    data: data,
                    success: function(response){
                        if(response){
                            var json_data = JSON.parse(response);
                            reloadContent(json_data);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            function deleteRecord(id, name)
            {
                $.ajax({
                    url: 'dashboard.php',
                    method: 'POST',
                    data: {del_picture_id: id, del_picture_name: name},
                    datatype: 'text',
                    success: function(response){
                        if(response){
                            $('#' + response).remove();
                        }
                    }
                });
            }

            function reloadContent(obj)
            {
                var id = obj.id;
                var is_approved = obj.is_approved;
                if(is_approved == 1){
                    $('#' + id).find('span.span-status').text("Approved");
                }
                else{
                    $('#' + id).find('span.span-status').html("<i>Rejected</i>");
                }
            }
        </script>
    </body>
</html>