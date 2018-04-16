<?php
session_start();
ini_set(display_errors, "On");

$rdir = __DIR__; // ルートディレクトリ
require("{$rdir}/db/db_init.php"); // データベースの設定

$fn = @htmlspecialchars($_GET['fn'], ENT_QUOTES);
if ($fn == "" || $fn == "gz_logon") {
    require("{$rdir}/php/gz_logon.php");
} else if ($fn == "gz_logon2") {
    require("{$rdir}/php/{$fn}.php");
} else if (!isset($_SESSION["us"]) || $_SESSION["us"] == null || $_SESSION["tm"] < time() - 300) {
    session_destroy();
    print "<p>ちゃんとログオンしてね！<br>
    <a href='/?fn=gz_logon'>ログオン</a></p>";
} else {
    $_SESSION["tm"] = time(); // タイムアウトの管理

    require("{$rdir}/php/{$fn}.php");
}
