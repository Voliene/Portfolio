<?php

/** @var \App\Model\Course $courses */
/** @var \App\Service\Router $router */

$title = 'Delete Course';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Delete Course</h1>
    <ul>

    <?php foreach ($courses as $course): ?>
        <li>

            <form action="<?= $router->generatePath('course-delete') ?>" method="post">
                <p> <?= $course->getCourseName()?> </p>
                <input type="hidden" name="action" value="course-delete">
                <input type="hidden" name="id" value="<?= $course->getCourseId() ?>">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
            </form>

        </li>
    <?php endforeach ?>

    </ul>
    <a href="<?= $router->generatePath('admin-index') ?>">Back to admin panel</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
