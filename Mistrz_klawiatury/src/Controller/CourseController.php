<?php

namespace App\Controller;
use App\Model\Admin;
use App\Service\Router;
use App\Service\Templating;
use App\Model\Course;

class CourseController
{

//    public function indexAction(Templating $templating, Router $router): ?string
//    {
//        $html = $templating->render('admin/index.html.php', [
//            'router' => $router,
//        ]);
//        return $html;
//    }

    public function indexAction(Templating $templating, Router $router): ?string
    {
        $courses = (new \App\Model\Course)->findAll();
        $html = $templating->render('course/index.html.php',[
            'courses' => $courses,
            'router' => $router
        ]);
        return  $html;
    }

    public function showAction(Templating  $templating,Router $router) :string
    {
        $courses = (new \App\Model\Course)->findAll();
        $html = $templating->render('course/index.html.php',[
            'courses' => $courses
            ,'router' => $router
        ]);
        return  $html;

    }

    public function createAction(?array $requestCourse, Templating $templating, Router $router): ?string
    {
        if ($requestCourse) {
            $course = Course::fromArray($requestCourse);

            $course->save();

            $path = $router->generatePath('admin-index');
            $router->redirect($path);
            return null;
        } else {
            $course = new Course();
        }

        $html = $templating->render('course/create.html.php', [
            'course' => $course,
            'router' => $router,
        ]);
        return $html;
    }


    
    public function deleteAction(?int $courseId,Templating  $templating,Router $router) : ?string
    {
        if ($courseId)
        {
            $course = (new \App\Model\Course)->find($courseId);
            $course->delete();
            $course = null;
            $path = $router->generatePath('course-delete');
            $router->redirect($path);
        }
        
        $courses = (new \App\Model\Course)->findAll();
        $html = $templating->render('course/delete.html.php',[
        'courses' => $courses
        ,'router' => $router
        ]);
        return  $html;
    }

    public function editAction(Templating $templating, Router $router): ?string
    {
        $courses = (new \App\Model\Course)->findAll();

        $html = $templating->render('course/edit.html.php', [
            'courses' => $courses,
            'router' => $router,
        ]);
        return $html;
    }

    public function editActionForm(int $id,Templating $templating, Router $router): ?string
    {
        $course = (new \App\Model\Course)->find($id);

        $html = $templating->render('course/edit_form.html.php', [
            'course' => $course,
            'router' => $router,
        ]);
        return $html;
    }

    public function trainAction(int $id,Templating $templating,Router  $router): ?string
    {
        $course = (new \App\Model\Course)->find($id);

        $html = $templating->render('test/test.html.php', [
            'course' => $course,
            'router' => $router,
        ]);
        return $html;
    }

    public function ownTextAction(Templating $templating, Router $router): ?string
    {
        $html = $templating->render('test/owntext.html.php', [
            'router' => $router,
        ]);
        return $html;
    }





}