<?php
$db = mysqli_connect('localhost', 'root', '', 'latihan');
$sql = mysqli_query($db, "SELECT * FROM mode WHERE id=1");
$data = mysqli_fetch_array($sql);
$mode = $data['mode'];

echo $mode;
?>