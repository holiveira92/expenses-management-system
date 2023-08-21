<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait APIException
{

    /**
     * Trata as exceções da API
     *
     * @param [type] $request
     * @param [type] $e
     * @return void
     */
    protected function getJsonException($request, $e)
    {

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->notFoundException($e);
        }

        if ($e instanceof MethodNotAllowedHttpException ) {
            return $this->httpException($e);
        }

        if ($e instanceof ValidationException) {
            return $this->validationException($e);
        }

        return $this->genericException($e);
    }

    /**
     * Retornar o erro 404
     *
     * @return void
     */
    protected function notFoundException(Exception $e)
    {

        // verificando status do model que gerou a exceção
        $modelNotFound = (is_object($e->getPrevious()) && !empty($e->getPrevious()->getModel())
            && ($e->getPrevious() instanceof ModelNotFoundException) )
            ? $e->getPrevious()->getModel()
            : false;

        // obtendo nome do model
        $modelName = (!empty($modelNotFound)) ? (new \ReflectionClass($modelNotFound))->getShortName() : "";

        // definindo mensagem de retorno
        $message = (!empty($modelName)) ? "$modelName ID not found" : (empty($e->getMessage()) ? 'Resource not found' : $e->getMessage()) ;

        return $this->getResponse(
            $message,
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Retornar o erro 500
     *
     * @return void
     */
    protected function genericException($e)
    {
        if(env('APP_ENV') != "production") {
            return $this->getResponse(
                "Internal server error", Response::HTTP_INTERNAL_SERVER_ERROR, $e
            );
        }

        return $this->getResponse(
            "Internal server error",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Retornar o erro de validação
     *
     * @return void
     */
    protected function validationException($e)
    {
        return response()->json($e->errors(), $e->status);
    }

    /**
     * Retornar o erro de http
     *
     * @return void
     */
    protected function httpException($e)
    {
        return $this->getResponse(
            $e->getMessage(),
            $e->getStatusCode()
        );
    }

    /**
     * Mostra a resposta em json
     *
     * @param [type] $message
     * @param [type] $code
     * @param [type] $status
     * @return void
     */
    protected function getResponse($message,  $status, $exception = null)
    {
        if(!empty($exception)) {
            return response()->json([
                "info" => "This error detail message only appears in non-production environments.",
                "error" => $message,
                "message" => $exception->getMessage(),
                "trace" => $exception->getTraceAsString()
            ], $status);
        }
        return response()->json([
            "error" => $message
        ], $status);
    }
}
