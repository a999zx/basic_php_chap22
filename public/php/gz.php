<?php
setcookie("gz_user", $_SESSION["us"], time() + 60*60*24*365);
setcookie("gz_date", date("Y年m月d日H時i分s秒"), time() + 60*60*24*365);
?>
<html>
<head>
    <meta charset='utf-8'>
    <title>たび写真館</title>
    <link rel='stylesheet' href='/css/gz_style_file.css' type='text/css'>
</head>
<body>
<div id='ue'>
    <p class='title'>たび写真館</p>
</div>
<div id='main'>
    <p class='iine'>（よかったら<u>イイネ！</u>を押してください）</p>

<?php
require_once($pager_path . DIRECTORY_SEPARATOR . "pager_init.php");

print_pager($page, $all_pages, $visible_pages);

$ps = $db->query("SELECT * FROM table1 WHERE ope = 1 ORDER BY ban DESC LIMIT $start, $contents");
$conts = $ps->fetchAll();
// $ps_end = $db->query("SELECT * FROM table1 WHERE ope = 1 ORDER BY ban DESC LIMIT " . ($start + $contents) .", 1");
$ps_ii = $db->query("SELECT DISTINCT * FROM table4
                     WHERE {$conts[0]["ban"]} >= ban
                     and ban >= {$conts[$contents - 1]["ban"]} ORDER BY ban DESC");
foreach ($conts as $r) {
    $tg = $r['gaz'];
    $tb = $r['ban'];
    $ii = null;
    $count_iine = 0;
    if (isset($r_tmp) && $r_tmp["ban"] == $tb) {
        $ii = "$ii {$r_tmp['nam']}";
        $count_iine++;
    }
    if (!isset($r_tmp) || $r_tmp["ban"] >= $tb) {
        while ($r_ii = $ps_ii->fetch()) {
            if ($r_ii["ban"] == $tb) {
                $ii = "$ii {$r_ii['nam']}";
                $count_iine++;
            } else if ($r_ii["ban"] > $tb) continue;
            else break;
        }
    }
    $r_tmp = $r_ii;

    print "<div id='box'>
    {$r['ban']}【投稿者:{$r['nam']}】{$r['dat']}
    <p class='iine'><a href='/?fn=gz_iine&page={$page}&tran_b={$tb}'>イイネ！</a>
    ($count_iine):$ii</p><br>"
    . nl2br($r['mes']) . "<br>
    <a href='/img/$tg' target='_blank'><img src='/img/thumb_$tg'></a><br>
    <p class='com'><a href='/?fn=gz_com&page={$page}&sn={$tb}'>コメントするときはここをクリック</a></p>";
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

print_pager($page, $all_pages, $visible_pages);

print "</div><div id='hidari'>
<a href='/?fn=gz_up&page={$page}'>画像をアップロードするときはここ</a>
<p><a href='/?fn=gz_logoff'>ログオフ</a></p></div>";
?>
</body>
</html>
