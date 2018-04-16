<?php
require_once("{$rdir}/db/gz_db_info.php");
$dsn = "mysql:host=$SERV;dbname=$DBNM";
$db = new PDO($dsn, $USER, $PASS);
