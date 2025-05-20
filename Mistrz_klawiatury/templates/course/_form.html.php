<?php
    /** @var $course ?\App\Model\Course */
?>

<div class="form-group">
    <label for="course_name">Course Name</label>
    <input type="text" id="course_name" name="course[course_name]" value="<?= $course ? $course->getCourseName() : '' ?>">
</div>

<div class="form-group">
    <label for="course_text">Train text</label>
    <textarea id="course_text" name="course[course_text]"><?= $course? $course->getCourseText() : '' ?></textarea>
</div>

<div class="form-group">
    <label for="course_difficulty">Difficulty</label>
    <select id="course_difficulty" name="course[course_difficulty]"><?= $course? $course->getCourseDifficulty() : '' ?>
        <option value="1">Easy</option>
        <option value="2">Medium</option>
        <option value="3">Hard</option>
    </select>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
