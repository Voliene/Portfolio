<?php

/** @var \App\Model\Course $course */
/** @var \App\Service\Router $router */

$title = 'Create Course';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Post</h1>
    <form action="<?= $router->generatePath('course-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="course-create">
    </form>

    <a href="<?= $router->generatePath('admin-index') ?>">Back to admin panel</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
