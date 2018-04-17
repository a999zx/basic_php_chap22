<?php
function create_page_link($page, $mark = null) {
    if ($mark == null) $mark = $page;
    global $request_uri;
    if (strpos($request_uri, "page=") !== false) {
        $link = preg_replace("/(page=)[0-9]*/", '${1}' . $page, $request_uri);
    } else {
        $link = $request_uri . "&page=" . $page;
    }
    return "<a href={$link}>{$mark}</a>";
}

function print_pager($now, $max, $visible) {
    if ($now - $visible <= 1) {
        for ($i = 1; $i < $now ; $i++) print create_page_link($i) . " ";
    } else {
        print create_page_link(1, "<<") . " ";
        print "... ";
        for ($i = $now - $visible; $i < $now ; $i++) print create_page_link($i) . " ";
    }

    print $now;

    if ($now + $visible >= $max) {
        for ($i = $now + 1; $i <= $max ; $i++) print " " . create_page_link($i);
    } else {
        for ($i = $now + 1; $i <= $now + $visible ; $i++) print " " . create_page_link($i);
        print "... ";
        print " " . create_page_link($max, ">>");
    }
}

$contents = 50; // 1ページあたりの表示数
$visible_pages = 3; //前後nページのリンクを表示する
$pager_ps = $db->query("SELECT COUNT(*) AS n FROM table1 WHERE ope = 1"); // 全体の投稿数
$all_contents = $pager_ps->fetch()["n"];
$all_pages = $all_contents % $contents === 0 ? (int)($all_contents / $contents) : (int)($all_contents / $contents) + 1; //全体のページ数
if ($page == "" || preg_match("/[^0-9]/", $page)) {
    $page = 1;
} else if ($page < 1 || $all_pages < $page) {
    $page = 1;
}
$start = $contents * ($page - 1);
