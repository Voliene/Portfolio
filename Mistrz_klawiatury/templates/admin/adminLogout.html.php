<?php
/** @var \App\Service\Router $router */

$title = 'Admin Panel';
$bodyClass = 'index';
ob_start(); ?>
    <h1>Admin Logout</h1>
    <p>Successfully logged out from Admin Panel.</p>
    <p><a href="<?= $router->generatePath('admin-login') ?>">Login again</a></p>


<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
