<?php
session_start();
// ini_set(display_errors, "On");

$rdir = __DIR__; // ルートディレクトリ
$php_path = $rdir . DIRECTORY_SEPARATOR . "php";
$db_path = $rdir . DIRECTORY_SEPARATOR . "db";
$img_path = $rdir . DIRECTORY_SEPARATOR . "img";
$pager_path = $rdir . DIRECTORY_SEPARATOR . "pager";
require($db_path . DIRECTORY_SEPARATOR . "db_init.php"); // データベースの設定

$fn = htmlspecialchars($_GET["fn"], ENT_QUOTES); // ファイル(.php)の名前
$page = htmlspecialchars($_GET["page"], ENT_QUOTES); // ページャ用現在ページ
$request_uri = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);
$phpfilelist = array_map("basename", glob($php_path . DIRECTORY_SEPARATOR . "*.php"));
if (($request_uri != "/" && !preg_match("/\/\?fn=.*/", $request_uri)) // 不正なURLを除外
    || ($request_uri != "/" && !in_array("{$fn}.php", $phpfilelist)) // 存在しないファイル(.php)へのアクセスを除外
    || (preg_match("/gz_admin*/", $fn) && $_SESSION["us"] !== "admin")) { // 管理者以外の管理ページへのアクセスを除外
    print "<p>ページが存在しません。<br>
           <a href='/?fn=gz_logon'>ログイン</a></p>";
} else if ($fn == "" || $fn == "gz_logon") { // デフォルトはログイン画面
    require($php_path . DIRECTORY_SEPARATOR . "gz_logon.php");
} else if ($fn == "gz_logon2" || $fn == "gz_logoff") {
    require($php_path . DIRECTORY_SEPARATOR . "{$fn}.php");
} else if (!isset($_SESSION["us"]) || $_SESSION["us"] == null || $_SESSION["tm"] < time() - 900) {
    session_destroy();
    print "<p>ちゃんとログオンしてね！<br>
    <a href='/?fn=gz_logon'>ログオン</a></p>";
} else {
    $_SESSION["tm"] = time(); // タイムアウトの管理

    require($php_path . DIRECTORY_SEPARATOR . "{$fn}.php");
}
