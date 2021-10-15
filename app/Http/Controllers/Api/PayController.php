<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class PayController extends Controller
{
    public function generate(Request $request, Gateway $gateway) 
    {
        // $token = $gateway->clientToken()->generate();

        // $data = [
        //     'success' => true,
        //     'token' => $token
        // ];
        $clientToken = $gateway->clientToken()->generate();
        return response()->json($clientToken);

    }
}
