<?php

namespace Yjtec\Exception;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $result = [];
        if(env('APP_DEBUG')){
            $traces = $exception->getTrace();
            $result['traces'] = $traces[0];
        }
        if($exception instanceof ApiException){
            $code = $exception->getCode();
            $extra = $exception->getExtra();
            $config = config("code.{$code}");
            if(!$config){
                $config  = config("code.UNKNOWN_CODE");
            }
            list($code,$msg) = $config;
            $result['errcode'] = $code;
            $result['errmsg'] = $msg;
            if($extra){
                $result['data'] = $extra;
                if(isset($extra['msg'])){
                    $result['errmsg'] = $extra['msg'];
                }
            }
            return response()->json($result);
        }
        if($exception instanceof ModelNotFoundException){
            $config = config("code.NOT_FOUND");
            list($code,$msg) = $config;
            $result['errcode'] = $code;
            $result['errmsg'] = $msg;
            return response()->json($result);
        }        
        return parent::render($request, $exception);
    }
}
