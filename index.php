<?php
/**
 * Created by PhpStorm.
 * User: Kalev
 * Date: 23.03.2018
 * Time: 19:57
 */
require_once 'C:/wamp64/www/phonebook/lib/tpl.php';
require_once 'read.php';

$line = $_POST['firstName'] . "," . $_POST['lastName'] . "," . $_POST['phone'] . "\n";
$write = file_put_contents('C:/wamp64/www/phonebook/data/data.txt', $line, FILE_APPEND | LOCK_EX);
if ($write === false) {
    die("cannot write!");
}

$lines = file('C:/wamp64/www/phonebook/data/data.txt');

$order_lines = [];
foreach ($lines as $line) {

    $parts = explode(',', trim($line));

    list($firstName, $lastName, $phone) = $parts;
    $order_lines[] = new OrderLine($firstName, $lastName, $phone);
}

$data = [
    '$order_lines' => $order_lines
];

print render_template('template/table.html', $data);