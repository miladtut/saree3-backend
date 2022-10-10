<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KashierController extends Controller
{
    function generateKashierOrderHash($order){
        $mid = "MID-14518-380"; //your merchant id
        $amount = $order->amount; //eg: 100
        $currency = $order->currency; //eg: "EGP"
        $orderId = $order->merchantOrderId; //eg: 99, your system order ID
        $secret = "2f88b5f5-740e-4f7b-b288-85635240a6f2";
        $path = "/?payment=".$mid.".".$orderId.".".$amount.".".$currency;
        $hash = hash_hmac( 'sha256' , $path , $secret ,false);
        return $hash;
    }
}
