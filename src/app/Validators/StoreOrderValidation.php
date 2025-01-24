<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreOrderValidation
{
    public static function validate(Request $request)
    {
        $validations = [
            "order" => ["required", "array"],
            "customerId" => ["required", "max:10", "numeric"],
            "order.*.productId" => ["required", "numeric"],
            "order.*.quantity" => ["required", "numeric"],
        ];

        $validator = Validator::make($request->all(), $validations);

        if ($validator->fails()) {
            return [
                'status' => BAD_REQUEST,
                'message' => VALIDATOR_FAILED
            ];
        }

        return $validator->validated();
    }
}
