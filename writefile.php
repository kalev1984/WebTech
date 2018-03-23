<?php
/**
 * Created by PhpStorm.
 * User: Kalev
 * Date: 23.03.2018
 * Time: 19:29
 */
$line = $_POST['firstName'] . "," . $_POST['lastName'] . "," . $_POST['phone'] . "\n";
$write = file_put_contents('C:/wamp64/www/phonebook/data/data.txt', $line, FILE_APPEND | LOCK_EX);
if ($write === false) {
    die("cannot write!");
} else {
    echo "success";
    header('Refresh: 5; URL=index.php');
}