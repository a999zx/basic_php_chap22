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
               <a href='/?fn=gz_up'>アップロード画面に戻る</a></p>";
    } else {
        // アップロードされた画像ファイルを移動
        $ima = date('YmdHis');
        $fn = $ima . $file['name'];
        move_uploaded_file($file['tmp_name'], './gz_img/' . $fn);

        // 各パラメータ取得
        $my_nam = htmlspecialchars($_POST['myn'], ENT_QUOTES);
        $my_mes = htmlspecialchars($_POST['mym'], ENT_QUOTES);
        $my_ipa = htmlspecialchars($_SERVER['REMOTE_ADDR'], ENT_QUOTES);
        $my_hos = htmlspecialchars($_SERVER['REMOTE_HOST'], ENT_QUOTES);

        // サムネイル作成
        $motogazo = imagecreatefromjpeg("/img/$fn");
        list($w, $h) = getimagesize("/img/$fn");
        $new_h = 200;
        $new_w = $w * 200 / $h;
        $mythumb = imagecreatetruecolor($new_w, $new_h);
        imagecopyresized($mythumb, $motogazo, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        imagejpeg($mythumb, "/img/thumb_$fn");

        // サムネイル表示
        print "<p>{$file['name']}のアップロードに成功！<br>
               <img src='/img/thumb_$fn'></p>";

        // データベースに追加
        $ps = $db->prepare("INSERT INTO table1 (nam, mes, ope, gaz, dat, ipa, hos) VALUES (?, ?, 1, ?, ?, ?, ?)");
        $ps->bindParam(1, $my_nam);
        $ps->bindParam(2, $my_mes);
        $ps->bindParam(3, $fn);
        $ps->bindParam(4, $ima);
        $ps->bindParam(5, $my_ipa);
        $ps->bindParam(6, $my_hos);
        $ps->execute();

        print "<a href=/?fn=gz>一覧表示へ</a>";
    }
} else {
    print "<p>名前とメッセージを入力し、JPEGファイルを選択してください。<br>
           <a href=/?fn=gz_up>再度アップロード</a></p>";
}
?>
</body>
</html>
