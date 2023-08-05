<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Throwable;

class ResponseFormatter
{
  static function success($message, $data = null, $statusCode = 200): JsonResponse
  {
    return response()->json([
      'status' => 'SUCCESS',
      'message' => $message,
      'data' => $data,
      'errors' => null
    ], $statusCode);
  }

  static function validationError(MessageBag $exception): JsonResponse
  {
    return response()->json([
      'status' => 'ERROR',
      'message' => 'Payload_Invalid',
      'data' => null,
      'errors' => $exception
    ], 422);
  }

  static function notFound(): JsonResponse
  {
    return response()->json([
      'status' => 'ERROR',
      'message' => 'Data_Not_Found',
      'data' => null,
      'errors' => null
    ], 404);
  }

  static function internalServerError(Exception | Throwable $errors): JsonResponse
  {
    return response()->json([
      'status' => 'ERROR',
      'message' => 'Internal_Server_Error',
      'data' => null,
      'errors' => $errors->getMessage()
    ], 500);
  }
}
