<?php
/**
 * Created by PhpStorm.
 * User: Kalev
 * Date: 23.03.2018
 * Time: 19:57
 */
require_once 'C:/wamp64/www/phonebook/lib/tpl.php';
require_once 'read.php';

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