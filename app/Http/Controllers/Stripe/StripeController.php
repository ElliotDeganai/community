<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Charge;
use Srmklive\PayPal\Services\ExpressCheckout;


class StripeController extends Controller
{
    public function stripe()
    {
        return Inertia::render('Stripe/Checkout', [
        ]);
    }

    public function stripePost(Request $request)
    {

        $user = User::find(1);
        $request->input('cart');

        try {
            $payment = $user->charge(
                $request->input('amount')*100,
                $request->input('payment_method_id')
            );

            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()
                ->create([
                    'transaction_id' => $payment->charges->data[0]->id,
                    'total' => $request->input('amount')
                ]);

                //dd($order);

            foreach ($request->input('cart') as $item) {
                $order->posts()
                    ->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            $order->load('posts')->load('posts.docValues');
            return Inertia::render('Stripe/Confirmation', [
                'getorder' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function paypalPost(Request $request)
    {
        $user = User::find(1);
        $request->input('cart');

        $order = $user->orders()
            ->create([
                'transaction_id' => $payment->charges->data[0]->id,
                'total' => $request->input('amount')
            ]);

            //dd($order);

        foreach ($request->input('cart') as $item) {
            $order->posts()
                ->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        $data = [];

        $data['product'] = [
            [
                'name' => 'Product 1',
                'price' => $request->input('amount'),
                'desc' => '',
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = 1;

        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";

        $data['return_url'] = route('payment.success');

        $data['cancel_url'] = route('payment.cancel');

        $data['total'] = 100;

        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);

        return redirect($response['paypal_link']);
    }
}
