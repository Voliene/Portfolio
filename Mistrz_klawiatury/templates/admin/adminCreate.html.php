<?php
/** @var \App\Service\Router $router */


$title = 'Admin Create';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Admin Create</h1>
        <form action="<?= $router->generatePath('admin-create-action') ?>" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Enter username">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter password">
        <input type="submit" value="Create new Admin">


<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';