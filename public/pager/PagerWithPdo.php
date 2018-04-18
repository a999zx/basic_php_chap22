<?php
class PagerWithPdo {
    protected static $_connection;
    protected $pdos;
    protected $now_page;
    protected $row_count;
    protected $all_pages;

    public function __construct() {
        if (!self::$_connection) {
            throw new Exception("setConnection()メソッドを実行してからnewしてください。");
        }
    }

    public static function getConnection() {
        if (!self::$_connection) {
            throw new Exception("Connectionがセットされていません。");
        }

        return self::$_connection;
    }

    public static function setConnection($host, $db, $user, $pass) {
        try {
            self::$_connection = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
        } catch (PDOException $e) {
            throw new Exception("接続に失敗しました。PDOのエラーメッセージ:" . PHP_EOL . $e->getMessage());
        }
    }

    public function select($sql, $now_page, $row_count, $all_contents) {
        if (!strcasecmp(strchr($sql, 0, 6), "select")) {
            throw new Exception("select文以外は不可。");
        }

        $this->row_count = $row_count;
        $this->all_pages = $all_contents % $row_count === 0
                           ? (int)($all_contents / $row_count) : (int)($all_contents / $row_count) + 1;

        if ($now_page == "" || preg_match("/[^0-9]/", $now_page)) {
            $this->now_page = 1;
        } else if ($now_page < 1 || $this->all_pages < $now_page) {
            $this->now_page = 1;
        } else {
            $this->now_page = $now_page;
        }
        $start = $row_count * ($this->now_page - 1);
        $this->pdos = self::$_connection->query("$sql ORDER BY ban DESC LIMIT $start, $row_count");
    }

    public function getPager($visible_pages) {
        $pager["now"] = $this->now_page;
        $pager["prev"] = ($this->now_page - $visible_pages > 0) ? ($this->now_page - $visible_pages) : 1;
        $pager["next"] = ($this->now_page + $visible_pages < $this->all_pages) ? ($this->now_page + $visible_pages) : $this->all_pages;
        $pager["row_count"] = $this->row_count;
        $pager["all_pages"] = $this->all_pages;
        $pager["result"] = $this->pdos->fetchAll();

        return $pager;
    }
}
