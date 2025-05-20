<?php

/** @var \App\Model\Course $courses */
/** @var \App\Service\Router $router */

$title = 'Choose Course';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Edit Course</h1>
    <ul>

        <?php foreach ($courses as $course): ?>
            <ul>
                    <li>
                        <a href="<?= $router->generatePath('course-edit-form', ['id' => $course->getCourseId()]) ?>">
                            <?= $course->getCourseName()?>
                        </a>
                    </li>
            </ul>
        <?php endforeach ?>

    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
