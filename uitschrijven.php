<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/sql.php";

if(isset($_GET["token"])) {
    unsubscribe($_GET["token"], $_GET["email"]);
}

