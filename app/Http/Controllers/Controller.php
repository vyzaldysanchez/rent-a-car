<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    public function __construct()
    {
        $this->response = response();
    }

    protected function success($data): JsonResponse
    {
        return $this->response->json($data, HttpStatus::SUCCESS);
    }

    protected function noContent(): JsonResponse
    {
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    protected function created($data): JsonResponse
    {
        return $this->response->json($data, HttpStatus::CREATED);
    }

    protected function unauthorized(): JsonResponse
    {
        return $this->response->json(null, HttpStatus::UNAUTHORIZED);
    }

    protected function unProcessableEntity(string $message): JsonResponse
    {
        return $this->response->json(new class($message)
        {
            public $code = HttpStatus::UNPROCESSABLE_ENTITY;
            public $message = '';

            public function __construct($message)
            {
                $this->message = $message;
            }
        }, HttpStatus::UNPROCESSABLE_ENTITY);
    }
}
