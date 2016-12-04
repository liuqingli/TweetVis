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
		
	$query = "SELECT screen_name as source, mention_name as target, count(*) as value
		FROM tweet_vis
		WHERE mention_name <> '' AND mention_name <> 'xunyou_flood' 
		AND screen_name <> mention_name AND created_time BETWEEN '$from_date' AND '$to_date'
		GROUP BY screen_name, mention_name
		ORDER BY value DESC
		LIMIT 40";

	if (empty($_GET['f']))
	{
		$query = "SELECT screen_name as source, mention_name as target, count(*) as value
			FROM tweet_vis 
			WHERE mention_name <> '' AND mention_name <> 'xunyou_flood' AND screen_name <> mention_name
			GROUP BY screen_name, mention_name
			ORDER BY value DESC
			LIMIT 40";
	}

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
