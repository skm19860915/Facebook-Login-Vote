<?php
function connectDb()
{
    // $conn = new mysqli('localhost', 'root', '', 'db_a47e9f_art');
    // //$conn = mysqli_connect('mysql5014.site4now.net', 'a47e9f_art', 'artart7766', 'db_a47e9f_art');
    // if ($conn->connect_error) 
    // {
    //     die("Connection failed: " . $conn->connect_error);
    //     return NULL;
    // } 

    // return $conn;

    

    $dbLink = new mysqli('localhost', 'root', '', 'db_a47e9f_art');
    //$dbLink = new mysqli('mysql5014.site4now.net', 'a47e9f_art', 'artart7766', 'db_a47e9f_art');
    $dbLink->query("SET character_set_results=utf8")or die(mysql_error());
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
    $dbLink->query("set names 'utf8'")or die(mysql_error());

    return $dbLink;
}

function selectQuery($sql)
{
    $conn = connectDb();
    $conn->query("SET character_set_results=utf8");
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function deleteQuery($sql)
{
    $status = NULL;
    $conn = connectDb();
    $result = $conn->query($sql);
    if ($result === TRUE) {
        $status = "success";
    } else {
        $status = NULL;
    }
    $conn->close();
    return $status;
}

function updateQuery($sql)
{
    $status = NULL;
    $conn = connectDb();
    $conn->query("SET character_set_client=utf8")or die(mysql_error());
    $conn->query("SET character_set_connection=utf8")or die(mysql_error());
    $result = $conn->query($sql);
    if ($result === TRUE) {
        $status = "success";
    } else {
        $status = NULL;
    }
    $conn->close();
    return $status;
}

function insertQuery($sql)
{
    $status = NULL;
    $conn = connectDb();
    $conn->query("SET character_set_client=utf8")or die(mysql_error());
    $conn->query("SET character_set_connection=utf8")or die(mysql_error());
    $result = $conn->query($sql);
    if ($result === TRUE) {
        $status = "success";
    } else {
        $status = NULL;
    }
    $conn->close();
    return $status;
}

// admin
function getArtistListOfDb()
{
    $sql = "select artists.*, pictures.id as pid, pictures.name as pname, pictures.description_1 as desc1, 
            pictures.description_2 as desc2, pictures.path as path, pictures.pending_status as status, pictures.votes as votes 
            from artists left join pictures on artists.id = pictures.artist_id";
    $result = selectQuery($sql);

    if ($result->num_rows > 0) {
        $data_arr = array();
        while($row = $result->fetch_assoc()) {
            $data_arr[] = $row;
        }
    }
    else{
        return NULL;
    }

    return $data_arr;
}

// user
function increaseVoteCount($id)
{
    $vote_count = 0;
    $sql = "select * from pictures where id = ".$id;
    $result = selectQuery($sql);
    
    if($result->num_rows > 0){
        $record = $result->fetch_assoc();
        $vote_count = $record["votes"] + 1;
    }

    $sql = "update pictures set votes = ".$vote_count." where id = ".$id;
    selectQuery($sql);
}
?>