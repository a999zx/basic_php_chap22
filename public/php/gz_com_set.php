<?php
$n = htmlspecialchars($_POST['myn'], ENT_QUOTES);
$c = htmlspecialchars($_POST['myc'], ENT_QUOTES);
$b = htmlspecialchars($_POST['myb'], ENT_QUOTES);
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>コメントを書き込みました</title>
</head>
<body style='background-color:lightblue'>

<?php
print "<p>{$n}さんは次のようにコメントを書き込みました</p>
<p>【コメント】<br>"
. nl2br($c) . "</p>
<a href='/?fn=gz'>一覧表示に戻ります</a>";

$ima = date("YmhHis");
$ps = $db->prepare("INSERT INTO table3 (ban, com, nam, dat) VALUES (?, ?, ?, ?)");
$ps->bindParam(1, $b);
$ps->bindParam(2, $c);
$ps->bindParam(3, $n);
$ps->bindParam(4, $ima);
$ps->execute();
?>
</body>
</html>
