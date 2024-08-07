<?php

namespace App\Http\Controllers;

use App\Http\Middleware\donotAllowUserToMakePayment;
use App\Http\Middleware\isEmployer;
use App\Mail\PurchaseMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubcriptionController extends Controller
{
    const WEEKLY_AMOUNT = 20;
    const MONTHLY_AMOUNT = 80;
    const YEARLY_AMOUNT = 200;
    const CURRENCY = 'USD';
    public function __construct()
    {
        $this->middleware(['auth', isEmployer::class, donotAllowUserToMakePayment::class]);
    }
    public function subscribe()
    {
        return view('subscription.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans =  [
            'weekly' => [
                'name' => 'weekly',
                'description' => 'weekly payment',
                'price' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'monthly' => [
                'name' => 'monthly',
                'description' => 'monthly payment',
                'price' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'yearly' => [
                'name' => 'yearly',
                'description' => 'yearly payment',
                'price' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
        ];

        Stripe::setApiKey(config('services.stripe.secret'));

        // Initiate payment
        try {
            $selectPlan = null;
            if ($request->is('pay/weekly')) {
                $selectPlan = $plans['weekly'];
                $billingEnds = now()->addWeek()->startOfDay()->toDateString();
            } elseif ($request->is("pay/monthly")) {
                $selectPlan = $plans['monthly'];
                $billingEnds = now()->addMonth()->startOfDay()->toDateString();
            } elseif ($request->is("pay/yearly")) {
                $selectPlan = $plans['yearly'];
                $billingEnds = now()->addYear()->startOfDay()->toDateString();
            }

            if ($selectPlan) {
                $successURL = URL::signedRoute('payment.success', [
                    'plan' => $selectPlan['name'],
                    'billing_ends' => $billingEnds
                ]);

                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $selectPlan['currency'],
                                'product_data' => [
                                    'name' => $selectPlan['name'],
                                    'description' => $selectPlan['description'],
                                ],
                                'unit_amount' => $selectPlan['price'] * 100,
                            ],
                            'quantity' => $selectPlan['quantity'],
                        ]
                    ],
                    'mode' => 'payment',
                    'success_url' => $successURL,
                    'cancel_url' => route('payment.cancel')
                ]);

                return redirect($session->url);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billingEnds = $request->billing_ends;
        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'billing_ends' => $billingEnds,
            'status' => "paid",

        ]);
        try {

            Mail::to(auth()->user())->queue(new PurchaseMail($plan, $billingEnds));
        } catch (\Exception $e) {
            return response()->json($e);
        }

        return redirect()->route('dashboard')->with('success', 'Payment was successfully processed');
    }
    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Payment was unsuccessful');
    }
}