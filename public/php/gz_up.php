<html>
<head>
    <meta charset=utf-8>
    <title>たび画像アップロード</title>
</head>
<body style='background-color:lightblue'>

<p style='color:deeppink;font-size:300%'>たび写真館</p>
<p>投稿よろしくお願いします！</p>
<form enctype='multipart/form-data' action='/?fn=gz_up_set' method='post'>
    名前<br>
    <input type='text' name='myn' value='<?php print $SESSION['us']; ?>'><br>
    メッセージ<br>
    <textarea name='mym' rows='10' cols='70'></textarea><br>
    <input type='file' name='myf'>
    <p>送信できるのは1MBまでのJPEG画像だけです！<br>
    また展開後のメモリ消費が多い場合アップロードできません。<br>
    <input type='submit' value='送信'><br>
    <a href='?fn=gz'>一覧表示へ</a></p>
</form>

</body>
</html>
