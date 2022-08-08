<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Status;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function paymentOrder($id){
        return Inertia::render('Frontend/Payment', ['order' =>Order::find($id)]);
    }

    public function confirmPayment(Request $request ){
        $order = null;
        $payment = Payment::create([
            'name' => 'paypal',
            'data' => json_encode($request->payment)
        ]);

        if( $payment ){
            $order = Order::where('id', $request->order_id)->update([
                'payment' => 'paid',
                'payment_id' => $payment->id
            ]);
        }

        if( $payment  && $order  ){
            return redirect()->route('order.index')->with('success','Payment success');
        }
    }

}
