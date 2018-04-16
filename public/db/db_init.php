<?php
require_once($db_path . DIRECTORY_SEPARATOR . "gz_db_info.php");
$dsn = "mysql:host=$SERV;dbname=$DBNM";
$db = new PDO($dsn, $USER, $PASS);
