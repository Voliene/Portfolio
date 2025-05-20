<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Post;
use App\Service\Router;
use App\Service\Templating;

class PostController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $posts = Post::findAll();
        $html = $templating->render('test/index.html.php', [
            'posts' => $posts,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $post = Post::fromArray($requestPost);
            // @todo missing validation
            $post->save();

            $path = $router->generatePath('test-index');
            $router->redirect($path);
            return null;
        } else {
            $post = new Post();
        }

        $html = $templating->render('test/create.html.php', [
            'test' => $post,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $postId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $post = Post::find($postId);
        if (! $post) {
            throw new NotFoundException("Missing test with id $postId");
        }

        if ($requestPost) {
            $post->fill($requestPost);
            // @todo missing validation
            $post->save();

            $path = $router->generatePath('test-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('test/edit_form.html.php', [
            'test' => $post,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $postId, Templating $templating, Router $router): ?string
    {
        $post = Post::find($postId);
        if (! $post) {
            throw new NotFoundException("Missing test with id $postId");
        }

        $html = $templating->render('test/show.html.php', [
            'test' => $post,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $postId, Router $router): ?string
    {
        $post = Post::find($postId);
        if (! $post) {
            throw new NotFoundException("Missing test with id $postId");
        }

        $post->delete();
        $path = $router->generatePath('test-index');
        $router->redirect($path);
        return null;
    }
}
