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

$query = "SELECT location as state, COUNT(*) as count FROM tweet_vis 
	WHERE created_time >= '$from_date' AND created_time <= '$to_date'
	GROUP BY location";

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
