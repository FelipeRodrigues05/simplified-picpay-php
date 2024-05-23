<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    public function render(): Response|Application|ResponseFactory
    {
        return response(['success' => false, 'message' => $this->message], 401);
    }
}
