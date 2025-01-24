<?php

namespace App\Http\Controllers\v1;

use App\Helpers\CommonFunctions;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Validators\StoreOrderValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = CommonFunctions::validateRequest($request, StoreOrderValidation::class);

        if (isset($validated['status']) && $validated['status'] === BAD_REQUEST) {
            return CommonFunctions::response(BAD_REQUEST, BAD_REQUEST_MSG);
        }

        $orders = $validated['order'];
        $customerId = $validated['customerId'];
        $overallPrice = 0;

        $productIds = array_column($orders, 'productId');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        DB::beginTransaction();

        try {
            $newOrder = new Order();
            $newOrder->customer_id = $customerId;
            $newOrder->total = $overallPrice;
            $newOrder->save();

            foreach ($orders as $order) {
                $product = $products->get($order['productId']);

                if (!$product || $order['quantity'] > $product->stock) {
                    throw new \Exception(PRODUCT_STOCK_IS_NOT_ENOUGH);
                }

                $totalPrice = $order['quantity'] * $product->price;

                $orderItem = new OrderItem();
                $orderItem->quantity = $order['quantity'];
                $orderItem->unit_price = $product->price;
                $orderItem->total = $totalPrice;
                $orderItem->product_id = $order['productId'];

                $newOrder->orderItems()->save($orderItem);

                $overallPrice += $totalPrice;
            }

            $newOrder->total = $overallPrice;
            $newOrder->save();

            DB::commit();

            return CommonFunctions::response(SUCCESS, [
                "message" => ORDER_CREATED,
                "orderId" => $newOrder->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return CommonFunctions::response(FAIL, $e->getMessage());
        }
    }

    public function delete($id)
    {
        $order = Order::find($id);

        if ($order) {
            if ($order->delete()) {
                return CommonFunctions::response(SUCCESS, ORDER_DELETED);
            } else {
                return CommonFunctions::response(FAIL, ORDER_DELETE_FAILED);
            }
        } else {
            return CommonFunctions::response(FAIL, ORDER_NOT_FOUND);
        }
    }
}
