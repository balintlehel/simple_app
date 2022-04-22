<?php

include 'config/credentials.php';
include 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    "driver"    => "mysql",
    "host"      => $db_host,
    "port"      => $db_port,
    "database"  => $db_name,
    "username"  => $db_user,
    "password"  => $db_pass,
    "protocol"  => "tcp",
    "charset"   => "utf8mb4",
    "collation" => "utf8mb4_general_ci",
    "prefix"    => ""
]);

$capsule->bootEloquent();
