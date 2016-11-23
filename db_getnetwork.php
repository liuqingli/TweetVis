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
	
	$query = "SELECT A.screen_name as source, B.mention_name as target, B.v as value FROM
		(SELECT ID, screen_name, count(*) AS v
		FROM tweet_vis
		WHERE mention_name <> ''
		GROUP BY screen_name
		ORDER BY v DESC
		LIMIT 8) A 
		JOIN
		(SELECT ID, screen_name, mention_name, count(*) AS v
		FROM tweet_vis 
		WHERE mention_name <> '' AND mention_name <> 'xunyou_flood' AND screen_name <> mention_name
		GROUP BY screen_name, mention_name
		ORDER BY v DESC) B 
		ON A.screen_name = B.screen_name
        ORDER BY A.screen_name";
		
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
