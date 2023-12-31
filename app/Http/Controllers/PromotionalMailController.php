<?php

namespace App\Http\Controllers;

use App\Mail\PromotionalMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PromotionalMailController extends Controller
{
    public function promotionPage() {
        return view( 'pages.promotion.promotion' );
    }

    public function sendPromotionMail( Request $request ){
        $customers = Customer::where( 'user_id', $request->header( 'id' ) )->select( 'email' )->get();
        try {
            foreach ( $customers as $customer ) {
                Mail::to( $customer->email )->send( new PromotionalMail( $request->subject, $request->message ) );
            }
            return response()->json( ['status' => 'success', 'message' => 'message send successfully'], 200 );
        } catch ( \Throwable $th ) {
            return response()->json( ['status' => 'failed', 'message' => 'message send failed'], 401 );
        }
    }
}
