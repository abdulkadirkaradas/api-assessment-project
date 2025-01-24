<?php

namespace App\Http\Controllers\v1;

use App\Helpers\CommonFunctions;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Validators\StoreOrderValidation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = CommonFunctions::validateRequest($request, StoreOrderValidation::class);

        if (isset($validated['status']) && $validated['status'] === BAD_REQUEST) {
            return CommonFunctions::response(BAD_REQUEST, BAD_REQUEST_MSG);
        }

        $product = Product::find($validated['productId']);

        $unitPrice = $validated['quantity'] * $product->price;

        $newOrder = new Order();
        $newOrder->customer_id = $validated['customerId'];
        $newOrder->total = $unitPrice;

        if ($newOrder->save()) {
            $orderItem = new OrderItem();
            $orderItem->quantity = $validated['quantity'];
            $orderItem->unit_price = $product->price;
            $orderItem->total = $unitPrice;
            $orderItem->product_id = $validated['productId'];

            if ($newOrder->orderItems()->save($orderItem)) {
                return CommonFunctions::response(SUCCESS, ORDER_CREATED);
            } else {
                return CommonFunctions::response(FAIL, ORDER_CREATION_FAILED);
            }
        } else {
            return CommonFunctions::response(FAIL, ORDER_CREATION_FAILED);
        }
    }
}
