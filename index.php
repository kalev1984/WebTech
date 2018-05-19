<?php
/**
 * Created by PhpStorm.
 * User: Kalev
 * Date: 23.03.2018
 * Time: 19:57
 */
require_once 'lib/tpl.php';
require_once 'read.php';
require_once 'read_detail.php';

$cmd = param('cmd') ? param('cmd') : 'form';

if ($cmd === 'add') {
    print render_template('template/add.html');
} else if($cmd === 'list') {
    //ReadFromFile();
    Read_sql();
} else if($cmd === 'save') {
    //WriteToFile();
    Write_sql();
    header('location: ?cmd=list');
} else if ($cmd === 'change') {
    //Alter Query
} else if($cmd === 'edit') {
    $id = $_GET['id'];
    Read_sql_id($id);
} else {
    Read_sql();
}

function param($key) {
    if (isset($_GET[$key])) {
        return $_GET[$key];
    } else if (isset($_POST[$key])) {
        return $_POST[$key];
    } else {
        return "";
    }
}

function WriteToFile()
{
    $line = "";
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['phone1'])) {
        $line = $_POST['firstName'] . "," . $_POST['lastName'] . "," . $_POST['phone1'] . "\n";
    }
    $write = file_put_contents('data/data.txt', $line, FILE_APPEND | LOCK_EX);
    if ($write === false) {
        die("cannot write!");
    }
}

function ReadFromFile() {
    $lines = file('data/data.txt');

    $order_lines = [];
    foreach ($lines as $line) {

        $parts = explode(',', trim($line));

        list($firstName, $lastName, $phone) = $parts;
        $order_lines[] = new OrderLine($firstName, $lastName, $phone);
    }

    $data = [
        '$order_lines' => $order_lines
    ];
    //header('location: template/table.html');
    print render_template('template/table.html', $data);
}

function Write_sql() {
    $connection = new PDO('sqlite:data/data.sqlite');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $firstName = "";
    $lastName = "";
    $phone1 = "";
    $phone2 = "";
    $phone3 = "";
    $owner_id = "";
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['phone1']) && isset($_POST['phone2']) &&
    isset($_POST['phone3'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone1 = $_POST['phone1'];
        $phone2 = $_POST['phone2'];
        $phone3 = $_POST['phone3'];
    } else {
        print('Error');
    }
    try {
        $query1 = "INSERT INTO contact (first_name, last_name) VALUES ('$firstName', '$lastName')";
        $statement1 = $connection->prepare($query1);
        $statement1->execute();
        $owner_id = $connection->lastInsertId();
        $query2 = "INSERT INTO numbers (phone1, phone2, phone3, owner_id) VALUES ('$phone1', '$phone2', '$phone3', '$owner_id')";
        $statement2 = $connection->prepare($query2);
        $statement2->execute();

    } catch (PDOException $e) {
        echo $e;
    }
}

function Read_sql() {
    $connection = new PDO('sqlite:data/data.sqlite');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$query = "SELECT id, * FROM contact";
    $query = "SELECT * FROM contact LEFT JOIN numbers ON contact.id = numbers.owner_id";
    $result = $connection->query($query);
    $rows = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }

    $order_lines = [];
    foreach ($rows as $r) {
        //list($id, $firstName, $lastName, $phone1, $phone2, $phone3, $ownerId) = $r;
        $firstName = $r['first_name'];
        $lastName = $r['last_name'];
        $id = $r['owner_id'];
        //$phone = "";
        $phone = $r['phone1'] . ', ' . $r['phone2'] . ', ' . $r['phone3'];
        $order_lines[] = new OrderLine($firstName, $lastName, $phone, $id);
    }
    $data = [
        '$order_lines' => $order_lines
    ];
    print render_template('template/table.html', $data);
}

function Read_sql_id($id) {
    $connection = new PDO('sqlite:data/data.sqlite');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$query = "SELECT id, * FROM contact";
    $query = "SELECT * FROM contact WHERE contact.id=$id";
    $query2 = "SELECT * FROM numbers WHERE owner_id = $id";
    $result = $connection->query($query);
    $rows = [];
    $rows2 = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    $result = $connection->query($query2);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $rows2[] = $row;
    }
    $order_lines = [];
    $firstName = '';
    $lastName = '';
    $phone1 = '';
    $phone2 = '';
    $phone3 = '';
    foreach ($rows as $row) {
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
    }
    foreach ($rows2 as $row) {
        $phone1 = $row['phone1'];
        $phone2 = $row['phone2'];
        $phone3 = $row['phone3'];
    }
    $order_lines[] = new OrderLine_detail($firstName, $lastName, $phone1, $phone2, $phone3);
    $data = [
        '$order_lines' => $order_lines
    ];
    print render_template('template/edit.html', $data);
}

function Update_sql($id) {
    $connection = new PDO('sqlite:data/data.sqlite');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $firstName = "";
    $lastName = "";
    $phone1 = "";
    $phone2 = "";
    $phone3 = "";
    $owner_id = $id;
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['phone1']) && isset($_POST['phone2']) &&
        isset($_POST['phone3'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone1 = $_POST['phone1'];
        $phone2 = $_POST['phone2'];
        $phone3 = $_POST['phone3'];
    } else {
        print('Error');
    }
    try {
        $query1 = "UPDATE contact SET first_name = :firstName, last_name = :lastName WHERE id = :id";
        $statement1 = $connection->prepare($query1);
        $statement1->execute();
        $owner_id = $connection->lastInsertId();
        $query2 = "UPDATE numbers SET phone1 = :phone1, phone2 = :phone2, phone3 = :phone3 WHERE owner_id = :id";
        $statement2 = $connection->prepare($query2);
        $statement2->execute();

    } catch (PDOException $e) {
        echo $e;
    }
}