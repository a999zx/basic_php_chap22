<html>
<head>
    <meta charset=utf-8>
    <title>アップロード完了</title>
</head>
<body style='background-color:khaki'>

<?php
$file = $_FILES['myf'];
$file_ext = strtolower(mb_strrchr($file['name'], '.', FALSE));
if ($_POST['myn'] <> "" && $_POST['mym'] <> "" && $file['size'] > 0
    && ($file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg')
    && ($file_ext == ".jpg" || $file_ext == ".jpeg")) {
    if ($file['size'] > 1024 * 1024) {
        unlink($file['tmp_name']);
        print "<p>アップするファイルのサイズは1MB以下にしてください<br>
               <a href='/?fn=gz_up&page={$page}'>アップロード画面に戻る</a></p>";
    } else {
        // アップロードされた画像ファイルを移動
        $ima = date('YmdHis');
        $fn = $ima . $file['name'];
        if (!file_exists($img_path)) mkdir($img_path);
        move_uploaded_file($file['tmp_name'], $img_path . DIRECTORY_SEPARATOR . $fn);

        // 各パラメータ取得
        $my_nam = htmlspecialchars($_POST['myn'], ENT_QUOTES);
        $my_mes = htmlspecialchars($_POST['mym'], ENT_QUOTES);

        // サムネイル作成
        $motogazo = imagecreatefromjpeg($img_path . DIRECTORY_SEPARATOR . $fn);
        list($w, $h) = getimagesize($img_path . DIRECTORY_SEPARATOR . $fn);
        $new_h = 200;
        $new_w = $w * 200 / $h;
        $mythumb = imagecreatetruecolor($new_w, $new_h);
        imagecopyresized($mythumb, $motogazo, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        imagejpeg($mythumb, $img_path . DIRECTORY_SEPARATOR . "thumb_$fn");

        // サムネイル表示
        print "<p>{$file['name']}のアップロードに成功！<br>
               <img src='/img/thumb_$fn'></p>";

        // データベースに追加
        $ps = $db->prepare("INSERT INTO table1 (nam, mes, ope, gaz, dat) VALUES (?, ?, 1, ?, ?)");
        $ps->bindParam(1, $my_nam);
        $ps->bindParam(2, $my_mes);
        $ps->bindParam(3, $fn);
        $ps->bindParam(4, $ima);
        $ps->execute();

        print "<a href=/?fn=gz>一覧表示へ</a>";
    }
} else {
    print "<p>名前とメッセージを入力し、JPEGファイルを選択してください。<br>
           <a href=/?fn=gz_up&page={$page}>再度アップロード</a></p>";
}
?>
</body>
</html>
