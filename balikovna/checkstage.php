<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
        $userdbconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
        if ($dbconn) {
            $id = $_POST['orderid'];
            $_SESSION['orderid'] = $id;
        }
        $result = pg_query($dbconn, "SELECT * FROM link_infos WHERE orderid='$id'");
        if ($result) {
          $row = pg_fetch_array($result, null, PGSQL_ASSOC);
        }

        $dbStage = $row["stage"];

        if ($dbStage != null) {
            echo $dbStage;
            pg_query($dbconn, "UPDATE link_infos SET stage = null WHERE orderid = '$id'");
        } else {
            echo '';
            pg_query($dbconn, "UPDATE link_infos SET stage = null WHERE orderid = '$id'");
        }
?>