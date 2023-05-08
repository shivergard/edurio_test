<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            //$this->print_call_stack();
            return new JsonResponse([
                'error' => 'Unauthorized action.',
                'message'=> $exception->getMessage()
            ], Response::HTTP_FORBIDDEN);
        }
    
        return parent::render($request, $exception);
    }

    function print_call_stack() {
        $trace = debug_backtrace();
        $output = '';
        foreach ($trace as $call) {
            if (isset($call['class']) && isset($call['function'])) {
                $output .= $call['class'] . '::' . $call['function'] . '()<br/>';
            }
        }
        echo $output;
    }
}
