<?php

namespace App\Controller;

use App\Model\Admin;
use App\Service\Router;
use App\Service\Templating;

class AdminController
{

    public function indexAction(Templating $templating, Router $router): ?string
    {
        if (!isset($_SESSION['uid']))
        {
            $html = $templating->render('admin/adminLogin.html.php', [
                'router' => $router,
            ]);
            return $html;

        }
        $html = $templating->render('admin/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function loginAction(Templating $templating, Router $router): ?string
    {
        /** @var $user Admin */
        global $user;

        if($user != null)
        {
            if ($user->getAdminId() != null) {
                $_SESSION['uid'] = $user->getAdminId();
                $path = $router->generatePath('admin-index');
                $router->redirect($path);
            }
        }
        $html = $templating->render('admin/adminLogin.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function verifyAction($name,$password, Router $router)
    {
        $admin = Admin::find($name,$password);
        if ($admin) {
            $_SESSION['uid'] = $admin->getAdminId();
            $path = $router->generatePath('admin-index');

        }
        else {
            $path = $router->generatePath('admin-login');
        }
        $router->redirect($path);


    }

    public function logoutAction(Templating $templating, Router $router): ?string
    {
        session_unset();
        session_destroy();
        $html = $templating->render('admin/adminLogout.html.php', [
            'router' => $router,
        ]);
        return $html;

    }

    public function adminCreate(Templating $templating, Router $router): ?string
    {
        $html = $templating->render('admin/adminCreate.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function adminCreateAction($name,$password, Router $router)
    {
        $admin = new Admin();
        $admin->setAdminName($name);
        $admin->setAdminPassword($password);
        $admin->save();
        $path = $router->generatePath('admin-login');
        $router->redirect($path);
    }
}