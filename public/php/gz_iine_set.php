<?php
$b = htmlspecialchars($_POST['myb'], ENT_QUOTES);
$n = htmlspecialchars($_POST['myn'], ENT_QUOTES);
?>
<html>
<head>
    <meta charset='utf-8'>
    <title>イイネを送信しました</title>
</head>
<body style='background-color:lightblue'>

<?php
$ps = $db->prepare("INSERT INTO table4 (ban, nam) VALUES (?, ?)");
$ps->bindParam(1, $b);
$ps->bindParam(2, $n);
$ps->execute();
print "<p>{$n}さんが「イイネ！」と言いました<br>
       <a href='/?fn=gz&page={$page}'>一覧表示に戻る</a></p>";
?>

</body>
</html>
