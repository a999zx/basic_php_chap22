<?php
setcookie("gz_user", $_SESSION["us"], time() + 60*60*24*365);
setcookie("gz_date", date("Y年m月d日H時i分s秒"), time() + 60*60*24*365);
?>
<html>
<head>
    <meta charset='utf-8'>
    <title>たび写真館　管理画面</title>
    <link rel='stylesheet' href='/css/gz_style_file.css' type='text/css'>
</head>
<body>
<p>ここは管理者のページです</p>
<p><a href='/?fn=gz_logoff'>ログオフ</a></p>
<form action='/?fn=gz_admin_op' method='post'>
<?php
$ps = $db->query("SELECT * FROM table1 ORDER BY ban DESC");
while ($r = $ps->fetch()) {
    $tg = $r['gaz'];
    $tb = $r['ban'];
    $to = $r['ope'];
    $ii = null;
    $ps_ii = $db->query("SELECT DISTINCT * FROM table4 WHERE ban = $tb");
    $count_iine = 0;
    while ($r_ii = $ps_ii->fetch()) {
        $ii = "$ii {$r_ii['nam']}";
        $count_iine++;
    }
    print "<div id='box'>
    対象{$r['ban']}
    <input type='checkbox' name='check[]' value=$tb";
    if ($to == 0) print " checked='checked'";
    print ">非公開<br>
    {$r['ban']}【投稿者:{$r['nam']}】{$r['dat']}
    <p class='iine'><a href='/?fn=gz_iine&tran_b=$tb'>イイネ！</a>
    ($count_iine):$ii</p><br>"
    . nl2br($r['mes']) . "<br>
    <a href='/img/$tg' target='_blank'><img src='/img/thumb_$tg'></a><br>
    <p class='com'><a href='/?fn=gz_com&sn=$tb'>コメントするときはここをクリック</a></p>";
    $ps_com = $db->query("SELECT * FROM table3 WHERE ban = $tb");
    $count = 1;
    while ($r_com = $ps_com->fetch()) {
        print "<p class='com'>●投稿コメント{$count}<br>
        【{$r_com['nam']}さんのメッセージ】{$r_com['dat']}<br>"
        . nl2br($r_com['com']) . "</p>";
        $count++;
    }
    print "</div>";
}
?>

<input type='submit' value='公開・非公開の送信'>
</form>
<p><a href='/?fn=gz_up'>画像をアップロードするときはここ</a></p>
<p><a href='/?fn=gz'>通常画面に戻る</a></p>
<p><a href='/?fn=gz_logoff'>ログオフ</a></p>

</body>
</html>
