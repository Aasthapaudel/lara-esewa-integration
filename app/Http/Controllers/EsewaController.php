<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use RemoteMerge\Esewa\Client;
// use RemoteMerge\Esewa\Config;
use RemoteMerge\Esewa\Config;

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
        $successUrl = url('/success');
        $failureUrl = url('/failure');

        // Config for development or production
        $config = new Config($successUrl, $failureUrl);

        // Initialize eSewa client
        $esewa = new Client($config);

        // Process the payment with eSewa
        $esewa->process($pid, $amount, 0, 0, 0);
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
