<?php
namespace Framework;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function handleErrorAction(FlattenException $exception)
    {
        if (404 === $exception->getStatusCode()) {
            $response = new Response('The page you are looking for does not exist.');
            $response->setStatusCode(404);

            return $response;
        }
        $response = new Response('Something went terribly wrong.');
        $response->setStatusCode(500);

        return $response;
    }

    public function __invoke(FlattenException $exception)
    {
        return $this->handleErrorAction($exception);
    }
}
