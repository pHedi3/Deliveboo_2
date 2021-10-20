<?php

namespace App\Http\Controllers\Api;

use Braintree\Gateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dish;

class PayController extends Controller
{

    public function generate(Request $request, Gateway $gateway) 
    {
        $token = $gateway->clientToken()->generate();
        
        $data = [
            'success' => true,
            'token' => $token
        ];
        
        return response()->json($data,200);    
    }
    public function payment(Request $request, Gateway $gateway) {
        $totalPrice = 0;
        foreach ($request->cart as $dish) {
            $dishTrue = Dish::find($dish['id']);
            $totalPrice += $dishTrue->price * $dish['quantity'];
        }

        $result = $gateway->transaction()->sale([
            'amount' => $totalPrice,
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        
        if ($result->success) {
            $data = [
                'success' => true,
                'message' => "Transazione avvenuta",
                'id' => $result->transaction->id
            ];
            return response()->json($data,200);

        }else {
            $data = [
                'success' => false,
                'message' => "Transazione fallita",
            ];
            return response()->json($data,401);
        }
    }
}
