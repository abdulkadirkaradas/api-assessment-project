<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreOrderValidation
{
    public static function validate(Request $request)
    {
        $validations = [
            "customerId" => ["required", "max:10", "numeric"],
            "productId" => ["required", "numeric"],
            "quantity" => ["required", "numeric"],
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
