<?php


if(getenv("YII_ENV") == 'prod') {
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=scps',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
} else {
    $clearDB = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $clearDB["host"];
    $username = $clearDB["user"];
    $password = $clearDB["pass"];
    $port = $clearDB["port"];
    $db = substr($clearDB["path"], 1);
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$server;port=$port;dbname=$db",
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
    ];
}


return $ret_arr;
