<html>
<head>
    <meta charset='utf-8'>
    <title>管理画面</title>
</head>
<body>
<?php
$n = $db->exec("UPDATE table1 SET ope = 1");
foreach ($_POST['check'] as $a => $b) {
    $n = $db->exec("UPDATE table1 SET ope = 0 WHERE ban = $b");
    print "{$b}は非公開です<br>";
}

print "<p><a href='/?fn=gz_admin&page={$page}'>管理画面に戻る</a></p>";
print "<p><a href='/?fn=gz&page={$page}'>通常画面に戻る</a></p>";
?>

</body>
</html>
