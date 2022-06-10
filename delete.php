<?php

require_once 'DB.php';
require_once 'Session.php';
require_once 'Region.php';

$id = $_GET["id"];

DB::connect('localhost', 'world', 'root', '');
$region = DB::selectOne("select * from `regions` where `id` = ?", [$id], 'Region');

if ($region === false) {
    echo 'Region with id ' . $id . ' not found.';
    exit();
}

$region->delete();
Session::instance()->flash('success_message', 'Region successfully deleted');

header('Location: index.php');
