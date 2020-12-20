<?php
#phpinfo();

#echo function_exists('mysqli_connect')?'1':'2';
$link = mysqli_connect("mysql", "root", "databaseforhomework22342233")or die(mysqli_connect_error());

$sql = "SHOW DATABASES;";
$res = mysqli_query($link, $sql);
while($r = mysqli_fetch_assoc($res)){
    echo print_r($r, 1);
}
?>