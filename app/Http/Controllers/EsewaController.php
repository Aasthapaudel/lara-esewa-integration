<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use RemoteMerge\Esewa\Client;
use RemoteMerge\Esewa\Config;
// use RemoteMerge\Esewa\Config;

class EsewaController extends Controller
{
    // Handle eSewa payment process
    public function esewaPay(Request $request)
    {
        $pid = uniqid();
        $amount = $request->amount;

        // Insert new order into database
        Order::insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            // 'email' => $request->email,
            'product_id' => $pid,
            'amount' => $amount,
            'esewa_status' => 'unverified',
            'created_at' => Carbon::now(),
        ]);

        // Set success and failure callback URLs
       // Set success and failure callback URLs.
$successUrl = url('/success');
$failureUrl = url('/failure');

// $config = new Config($successUrl, $failureUrl);

// Initialize eSewa client for development.
$esewa = new Client([
    'merchant_code' => 'EPAYTEST',
    'success_url' => $successUrl,
    'failure_url' => $failureUrl,
]);

// Initialize eSewa client for production.
$esewa = new Client([
    'merchant_code' => 'b4e...e8c753...2c6e8b',
    'success_url' => $successUrl,
    'failure_url' => $failureUrl,
]);
    }
    // Handle successful eSewa payment
    public function esewaPaySuccess(Request $request)
    {
        // Get necessary parameters from request
        $pid = $request->query('oid');
        $refId = $request->query('refId');
        $amount = $request->query('amt');

        // Find the corresponding order
        $order = Order::where('product_id', $pid)->first();

        // Update the order status
        if ($order) {
            $order->update([
                'esewa_status' => 'verified',
                'updated_at' => Carbon::now(),
            ]);

            // Send mail, etc.
            $msg = 'Success';
            $msg1 = 'Payment success. Thank you for making a purchase with us.';
            return view('thankyou', compact('msg', 'msg1'));
        }
        return redirect('/failure'); // Handle case where order is not found
    }

    // Handle failed eSewa payment
    public function esewaPayFailed(Request $request)
    {
        // Get necessary parameters from request
        $pid = $request->query('pid');

        // Find the corresponding order
        $order = Order::where('product_id', $pid)->first();

        // Update the order status
        if ($order) {
            $order->update([
                'esewa_status' => 'failed',
                'updated_at' => Carbon::now(),
            ]);

            // Send mail, etc.
            $msg = 'Failed';
            $msg1 = 'Payment failed. Contact admin for support.';
            return view('thankyou', compact('msg', 'msg1'));
        }
        return redirect('/failure'); // Handle case where order is not found
    }
}

