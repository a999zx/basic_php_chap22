<?php
$u = $_GET['sn'];
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>コメントをどうぞ！</title>
</head>
<body style='background-color:lightblue'>

<?php
print "<p>{$u}番の画像に対するコメントをどうぞ！</p>
       <form action='/?fn=gz_com_set' method='post'>
       名前<br>
       <input type='text' name='myn' value='{$_SESSION['us']}'><br>
       コメント<br>
       <textarea name='myc' rows='10' cols='70'></textarea><br>
       <input type='hidden' name='myb' value='$u'>
       <input type='submit' value='送信'>
       </form>
       <p><a href='/?fn=gz'>一覧表示に戻る</a></p>";
?>
</body>
</html>
