<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class CommonFunctions {
    /**
     * Returns API responses
     *
     * @param int $status
     * @param mixed $message
     * @param string $error
     * @return array
     */
    public static function response(int $status, mixed $message = null)
    {
        $response = [
            'status' => $status,
            'message' => $message ?? '',
        ];

        return response()->json($response);
    }

    /**
     * Validates informations in the request body
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $validator
     * @return mixed
     */
    public static function validateRequest(Request $request, $validator)
    {
        $validated = $validator::validate($request);

        if (gettype($validated) === 'array' && isset($validated['status']) && $validated['status'] === BAD_REQUEST) {
            return $validated;
        }

        return $validated;
    }
}
