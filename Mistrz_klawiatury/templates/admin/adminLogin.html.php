<?php
/** @var \App\Service\Router $router */

$title = 'Admin Panel';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Admin Login</h1>
    <form action="<?= $router->generatePath('admin-verify') ?>" method="post">
    <label for="username">Username</label>
    <input type="text" name="username" placeholder="Username">
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login to Admin Panel">


<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';