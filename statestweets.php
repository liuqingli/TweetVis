<?php
$from_date = date_parse(base64_decode($_GET['f']));
$to_date = date_parse(base64_decode($_GET['t']));

echo "state,count";
echo "\nMA,";
echo mt_rand(0,10);
echo "\nVA,";
echo mt_rand(0,10);
echo "\nNJ,";
echo mt_rand(0,10);
echo "\nNY,";
echo mt_rand(0,10);
echo "\nCA,";
echo mt_rand(0,10);
?>
