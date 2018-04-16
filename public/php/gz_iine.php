<?php
$b = $_GET['tran_b'];
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>イイネを送信します</title>
</head>
<body style='background-color:khaki'>

<?php
print "<p>{$b}番の投稿に<u>イイネ！</u>と言いました</p>
       名前を入力してください<br>
       <form action='/?fn=gz_iine_set' method='post'>
       名前<br>
       <input type='text' name='myn' value='{$_SESSION['us']}'><br>
       <input type='hidden' name='myb' value='$b'>
       <input type='submit' value='送信'>
       </form>";
?>

</body>
</html>
