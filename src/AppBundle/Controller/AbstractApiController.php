<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController extends Controller
{
    /**
     * @param array $content
     * @param int $statusCode
     *
     * @return Response
     */
    private function jsonResponse(array $content = [], int $statusCode = Response::HTTP_OK) : Response
    {
        return new Response(
            json_encode($content),
            $statusCode,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Sometimes stuff doesn't go to plan and we need to throw exceptions.
     *
     * @param string|null $message
     * @param int $statusCode
     *
     * @return Response
     */
    public function jsonException(
        string $message = null,
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ) : Response
    {
        // TODO Add a queue item to log an error, we don't want to throw a php exception on a json endpoint.
        if (! $message) {
            return $this->jsonResponse(['error' => 'There has been an error. Oh no.'], $statusCode);
        }

        return $this->jsonResponse(['error' => $message], $statusCode);
    }
}
