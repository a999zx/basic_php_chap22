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
