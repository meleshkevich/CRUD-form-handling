<?php
require_once 'DB.php';
require_once "DB_functions.php";
require_once 'Region.php';
require_once 'Session.php';
require_once 'helpers.php';

DB::connect(
    '127.0.0.1',    //host of the Database
    'world',        //database name
    'root',         //username
    ''              //password
);

$id = isset($_GET["id"]) ? $_GET["id"] : null;

// //process data
if (isset($id)) {
    // edit existing record, if id is set
    $region = DB::selectOne("SELECT * FROM `regions` WHERE `id` = ?", [$id], 'Region');

    if ($region === false) {
        echo 'Region with id' . $id . ' not found.';
        exit();
    }
} else {
    // create a new record
    $region = new Region;
}

// -- Data validation block --
$valid = true; // everything is ok
$errors = []; // error messages

if (empty($_POST['name'])) {
    $valid = false;
    $errors[] = 'The name field is mandatory';
}

if (empty($_POST['slug'])) {
    $valid = false;
    $errors[] = 'The slug field is mandatory';
}

if ($valid === false) {
    // validation failed :-(

    // flash the (bad) request data
    Session::instance()->flashRequest();

    // flash the error messages
    Session::instance()->flash('errors', $errors);

    // redirect back
    if ($id) {
        header('Location: edit.php?id=' . $id);
    } else {
        header('Location: edit.php');
    }
    exit(); // stop execution of the script
}


// // update the data from the request
$region->name = $_POST['name'] ?? $region->name;
$region->slug = $_POST['slug'] ?? $region->slug;
$region->save();

Session::instance()->flash('success_message', 'Record successfully added!');

header('Location: edit.php?id=' . $region->id);
