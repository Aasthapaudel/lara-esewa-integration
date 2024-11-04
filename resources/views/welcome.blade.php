<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Esewa in Laravel</title>

</head>

<body class="antialiased">


    <div class="title m-b-md">
        eSewa Checkout
    </div>

    <div class="links">

        @if($message = session('message'))
            <p>
                {{ $message }}
            </p>
        @endif

        <p>
            <strong>QuietComfort® 25 Acoustic Noise Cancelling® headphones — Apple devices</strong>
        </p>

        <br>

        <form method="POST" action="{{ route('checkout.payment.esewa.process', $order->id) }}">

            @csrf

            <input type="hidden" name="data" value="{{ base64_encode(json_encode([
                'transaction_code' => 'TX12345',
                'status' => 'completed',
                'total_amount' => 1000,
                'transaction_uuid' => 'UUID12345',
                'product_code' => 'PROD001',
                'signed_field_names' => 'transaction_code,status,total_amount,transaction_uuid,product_code',
                'signature' => 'dummy_signature'
            ])) }}">

            <button type="submit">Submit Dummy Transaction</button>
        </form>
    </div>
</body>

</html>
