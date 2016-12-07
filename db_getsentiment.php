<?php
    $from_date = date("Y-m-d H:i:s", strtotime(base64_decode($_GET['f'])));
    $to_date = date("Y-m-d H:i:s", strtotime(base64_decode($_GET['t'])));

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
    mysqli_set_charset($link,"utf8");

    $query = "SELECT location,
		SUM(CASE WHEN compound_value between 0.4 and 1 THEN 1 END) AS `pos`,
		SUM(CASE WHEN compound_value between -1 and -0.4 THEN 1 END) AS `neg`,
		SUM(CASE WHEN compound_value between -0.4 and 0.4 THEN 1 END) AS `neu`
		FROM tweet_vis
		WHERE created_time BETWEEN '$from_date' AND '$to_date'
		GROUP BY location";

    if (empty($_GET['f']))
    {
        $query = "SELECT location,
		SUM(CASE WHEN compound_value between 0.4 and 1 THEN 1 END) AS `pos`,
		SUM(CASE WHEN compound_value between -1 and -0.4 THEN 1 END) AS `neg`,
		SUM(CASE WHEN compound_value between -0.4 and 0.4 THEN 1 END) AS `neu`
		FROM tweet_vis
		GROUP BY location";
    }
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
