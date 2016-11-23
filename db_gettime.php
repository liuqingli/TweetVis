<?php
    require("config.php");
    $link = mysqli_init();
    $success = mysqli_real_connect(
        $link, 
        $host, 
        $user, 
        $password, 
        $db,
        $port
    );

    $query = "SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_time)/300 ) * 300) AS date, count(*) as count FROM tweet_vis 
	      GROUP BY year(created_time), month(created_time), day(created_time), 		      ((60/5) * HOUR(created_time) + FLOOR(MINUTE(created_time)/5))";

    $result = mysqli_query($link, $query);

    $data = array();
    while($row = $result->fetch_assoc())
    {
        $data[] = $row;
    }
    echo json_encode($data);  

    /* free result set */
    mysqli_free_result($result);

    /* close connection */
    mysqli_close($link);
?>
