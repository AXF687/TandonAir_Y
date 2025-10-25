<?php
$db = mysqli_connect('localhost', 'root', '', 'latihan');
$sql = mysqli_query($db, "SELECT * FROM pompa WHERE id=1");
$data = mysqli_fetch_array($sql);
$manual = $data['manual'];

echo $manual;