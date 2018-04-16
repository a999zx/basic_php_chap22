<?php
$_SESSION = array();
if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", "", time() - 3600, "/");
}
session_destroy();
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>ご利用ありがとうございました</title>
</head>
<body>
    <p style='color:red'>たび写真館</p>
    <p>またのご来場をお待ちしております<br>
    <a href='/?fn=gz_logon'>再度ログオンするときはここから</a></p>
</body>
</html>
