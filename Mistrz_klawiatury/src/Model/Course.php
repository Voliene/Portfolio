<?php

namespace App\Model;

use App\Service\Config;

class Course
{
    private ?int $courseId = null;
    private ?string $courseText = null;
    private ?string $courseName = null;
    private ?int $courseDifficulty = null;

    public function getCourseName(): ?string
    {
        return $this->courseName;
    }

    public function setCourseName(?string $courseName): void
    {
        $this->courseName = $courseName;
    }

    public function getCourseDifficulty(): ?int
    {
        return $this->courseDifficulty;
    }

    public function setCourseDifficulty(?int $courseDifficulty): void
    {
        $this->courseDifficulty = $courseDifficulty;
    }


    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): Course
    {
        $this->courseId = $courseId;

        return $this;
    }

    public function getCourseText(): ?string
    {
        return $this->courseText;
    }

    public function setCourseText(?string $courseText): Course
    {
        $this->courseText = $courseText;

        return $this;
    }

    public static function fromArray($array): Course
    {
        $course = new self();
        $course->fill($array);

        return $course;
    }

    public function fill($array): Course
    {

        if (isset($array['course_id'])) {
            $this->setCourseId(intval($array['course_id']));
        }
        if (isset($array['course_text'])) {
            $this->setCourseText($array['course_text']);
        }
        if (isset($array['course_name'])) {
            $this->setCourseName($array['course_name']);
        }
        if (isset($array['course_difficulty'])) {
            $this->setCourseDifficulty(intval($array['course_difficulty']));
        }

        return $this;

    }

    public function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM course ORDER BY course_difficulty';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $courses = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $courses[] = Course::fromArray($row);
        }

        return $courses;

    }

    public function find($id): Course
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM course WHERE course_id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $courseArray = $statement->fetch(\PDO::FETCH_ASSOC);

        return Course::fromArray($courseArray);

    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if ($this->getCourseId()) {
            $sql = "UPDATE course SET course_text = :course_text,course_name = :course_name,course_difficulty = :course_difficulty WHERE course_id = :course_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':course_id' => $this->getCourseId(),
                ':course_text' => $this->getCourseText(),
                ':course_name' => $this->getCourseName(),
                ':course_difficulty' => $this->getCourseDifficulty()
            ]);
        } else {
            $sql = "INSERT INTO course (course_name,course_text,course_difficulty) 
                    VALUES (:course_name,:course_text,:course_difficulty)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':course_text' => $this->getCourseText(),
                ':course_name' => $this->getCourseName(),
                ':course_difficulty' => $this->getCourseDifficulty()

            ]);
            $this->setCourseId((int)$pdo->lastInsertId());
        }

    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM course WHERE course_id = :course_id ";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':course_id' => $this->getCourseId()
        ]);
    }

    public function update(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if ($this->getCourseId()) {
            $sql = "UPDATE course SET course_text = :course_text, course_name = :course_name, course_difficulty = :course_difficulty WHERE course_id = :course_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':course_id' => $this->getCourseId(),
                ':course_text' => $this->getCourseText(),
                ':course_name' => $this->getCourseName(),
                ':course_difficulty' => $this->getCourseDifficulty()
            ]);
        }
    }
}