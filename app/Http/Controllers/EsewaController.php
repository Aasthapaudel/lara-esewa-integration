<?php

namespace App\Http\Controllers;

use App\Esewa;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

/**
 * Class EsewaController
 * @package App\Http\Controllers
 */


 class EsewaController extends Controller{
    public function checkout(Order $product){
      return (new Esewa)->pay(1000,route('esewa.verification',['product' => $product->slug]),$product->id,$product->name);
    }

    public function verification(Order $product, Request $request){
          $esewa = new Esewa;
          $decodedString = base64_decode($request->data);
          $data = json_decode($decodedString, true);
          $transaction_code = $data['transaction_code'] ?? null;
          $status = $data['status'] ?? null;
          $total_amount = $data['total_amount'] ?? null;
          $transaction_uuid = $data['transaction_uuid'] ?? null;
          $product_code = $data['product_code'] ?? null;
          $signed_field_names = $data['signed_field_names'] ?? null;
          $signature = $data['signature'] ?? null;
          $inquiry = $esewa->inquiry($transaction_uuid, [
              'transaction_code' => $transaction_code,
              'status' => $status,
              'total_amount' => $total_amount,
              'transaction_uuid' => $transaction_uuid,
              'product_code' => $product_code,
              'signed_field_names' => $signed_field_names,
              'signature' => $signature,
          ]);
       $esewa->isSuccess($inquiry) ? dd('Success') : dd('failed');

        }
        }
