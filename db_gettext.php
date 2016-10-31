<?php
    $user = 'cs5764';
    $password = 'cs5764';
    $db = 'cs5764';
    $host = 'localhost';
    $port = 3306;

    $link = mysqli_init();
    $success = mysqli_real_connect(
        $link, 
        $host, 
        $user, 
        $password, 
        $db,
        $port
    );
    mysqli_set_charset($link,"utf8");

    $query = "SELECT text FROM tweet_vis";

    $result = mysqli_query($link, $query);

    $data = array();
    while($row = $result->fetch_assoc())
    {
        $data[] = $row;
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);  
    /* free result set */
    mysqli_free_result($result);

    /* close connection */
    mysqli_close($link);
?>
