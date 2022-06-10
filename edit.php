<?php

require_once 'DB.php';
require_once 'Session.php';
require_once 'helpers.php';
require_once 'Region.php';

$success_message = Session::instance()->get('success_message');
$errors = Session::instance()->get('errors', []);

$id = isset($_GET["id"]) ? $_GET["id"] : null;

if (isset($id)) {
    DB::connect('localhost', 'world', 'root', '');
    $region = DB::selectOne("SELECT * FROM `regions` WHERE `id` = ?", [$id], 'Region');

    if ($region === false) {
        echo 'Region with id ' . $id . ' not found.';
        exit();
    }
} else {
    $region = new Region();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style.css">
    <title>Region</title>
</head>

<body>
    <?php if ($success_message) : ?>
        <div class="message message_success">
            <?= $success_message ?>
        </div>
    <?php endif; ?>

    <?php foreach ($errors as $error) : ?>
        <div class="message message_error">
            <?= $error ?>
        </div>
    <?php endforeach; ?>

    <?php if (isset($id)) : ?>
        <form action="save.php?id=<?= $region->id ?>" method="post" class="form">
        <?php else : ?>
            <form action="save.php" method="post" class="form">
            <?php endif; ?>
            <label>Name:</label>
            <input type="text" name="name" value="<?= old('name', $region->name) ?>" />

            <label>Slug:</label>
            <input type="text" name="slug" value="<?= old('slug', $region->slug) ?>" />

            <br />
            <div class="buttons">
                <button>Save</button>

                <?php if (isset($id)) : ?>
                    <a href="delete.php?id=<?= $region->id ?>">
                        <button type="button">Delete</button>
                    </a>
                <?php endif; ?>


                <a href="index.php">
                    <button type="button">Back</button>
                </a>
            </div>
            </form>
</body>

</html>