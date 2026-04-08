<?php
include "../config/koneksi.php";

$text = $_POST['text'];
$category = $_POST['category'];
$priority = $_POST['priority'];

mysqli_query($conn,"
INSERT INTO todos(text,category,priority)
VALUES('$text','$category','$priority')
");

header("Location: ../index.php");
exit;
