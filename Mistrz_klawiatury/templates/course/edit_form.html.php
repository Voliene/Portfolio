<?php

/** @var \App\Model\Course $course */
/** @var \App\Service\Router $router */

$title = "Edit Course";
$bodyClass = "edit";

ob_start();
?>
    <h1>Edit Course</h1>

    <form action="<?= $router->generatePath('course-create') ?>" method="post">
        <?php if ($course): ?>
            <label for="courseName">Course Name:</label>
            <input type="text" id="courseName" name="course[course_name]" value="<?= $course->getCourseName() ?>" required>

            <label for="courseText">Course Text:</label>
            <textarea id="courseText" name="course[course_text]" required><?= $course->getCourseText() ?></textarea>

            <label for="course_difficulty">Course Difficulty:</label>
            <select id="course_difficulty" name="course[course_difficulty]"><?= $course->getCourseDifficulty()  ?>
                <option value="1">Easy</option>
                <option value="2">Medium</option>
                <option value="3">Hard</option>
            </select>

            <input type="hidden" name="course[course_id]" value="<?= $course->getCourseId() ?>">

            <input type="submit" value="Edit">
        <?php endif; ?>
    </form>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('admin-index') ?>">Back to list</a></li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
