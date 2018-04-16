<?php
$u = htmlspecialchars($_POST['user'], ENT_QUOTES);
$p = htmlspecialchars($_POST['pass'], ENT_QUOTES);
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>ようこそ！　たび写真館</title>
</head>
<body>

<?php
$ps = $db->query("SELECT pas FROM table2 WHERE id = '$u'");
if ($ps->rowCount() > 0) {
    $r = $ps->fetch();
    if ($r['pas'] === md5($p)) {
        $_SESSION['us'] = $u;
        $_SESSION['tm'] = time();
        if ($u === "admin") {
            print "管理者のページにどうぞ<br>
                   <a href='/?fn=gz_admin'>管理者のページ</a>";
        } else {
            print "<p>一般ユーザー{$u}さん<br>
                   ようこそ　たび写真館へ！</p>
                   <a href='/?fn=gz'>ここをクリックして一覧表示にどうぞ</a>";
        }
    } else {
        session_destroy();
        print "<p>登録されていないか、パスワードが違います。<br>
               <a href='/?fn=gz_logon'>ログオン</a></p>";
    }
} else {
    session_destroy();
    print "<p>登録されていないか、パスワードが違います。<br>
           <a href='/?fn=gz_logon'>ログオン</a></p>";
}
?>

</body>
</html>
