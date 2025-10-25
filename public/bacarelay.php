<?php
$db = mysqli_connect('localhost', 'root', '', 'latihan');
$sql = mysqli_query($db, "SELECT * FROM kendalirelay WHERE id=1");
$data = mysqli_fetch_array($sql);
$relay = $data['relay'];

echo $relay;