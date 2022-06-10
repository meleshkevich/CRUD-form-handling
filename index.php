<?php

require_once 'DB.php';
require_once 'Region.php';
require_once 'Session.php';

$success_message = Session::instance()->get('success_message');

$success = DB::connect(
    '127.0.0.1',    //host of the Database
    'world',        //database name
    'root',         //username
    ''              //password
);

$sql = '
SELECT *
FROM `regions`
WHERE 1;
';

$data = DB::select($sql, [], 'Region');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Region</title>
</head>

<body>
    <main>

        <a class="create" href="edit.php"><button>Create new region</button></a>
        <?php foreach ($data as $region) : ?>
            <div class="region">
                <div class="region_name"><b>Region name:</b> <?= $region->name ?></div>
                <div class="region_slug"><b>Region slug: </b> <?= $region->slug ?></div>
                <a class="region_button" href="edit.php?id=<?= $region->id ?>"><button>Edit region</button></a>
            </div>
        <?php endforeach; ?>
    </main>
</body>

</html>