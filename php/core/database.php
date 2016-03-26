<?php

class Database {
    private static $instance;

    private function __construct() {
        self::$instance = new PDO('mysql-phaaron.alwaysdata.net', 'phaaron', 'aaronaaron');
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new PDO('mysql:dbname=phaaron_base1;host=mysql-phaaron.alwaysdata.net',
                'phaaron', 'aaronaaron');
        }

        return self::$instance;
    }
}