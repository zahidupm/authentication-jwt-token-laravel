<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class UserController extends Controller
{
    public  function index(Request $request){

        try {
            User::create([
                'firstName'=> $request->input('firstName'),
                'lastName'=> $request->input('lastName'),
                'email'=> $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => $request->input('password'),
            ]);

            return response()->json(['message' => 'User Created Successfully'], 201);
        } catch (Exception $e){
            return response()->json(['status' => 'failed','message' => $e->getMessage() ]);
        }

    }

    public function login(Request $request)
    {
        // how to bcrypt the password
        $user = User::where('email', $request->input('email'))->first();

        if (!$user ||!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['status' => 'failed','message' => 'Invalid Credentials'], 401);
        }

        $token = JWTToken::createToken($user);

        return response()->json(['status' =>'success', 'token' => $token], 200);

//            $result = User::where('email', '=', $request->email)->where('password', '=', $hash)
//            ->count();
//
//            if($result == 1 ){
//                $token = JWTToken::createToken($request->input('email'));
//                return response()->json(['token' => $token], 200);
//            } else {
//                return response()->json(['status' => 'failed','message' => 'Invalid Credentials'], 401);
//            }
    }

    public function sendOTPCode(Request $request,){
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if($count == 1 ){
            // otp email address
            Mail::to($email)->send(new OTPMail($otp));
            // otp code table update
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json(['status' =>'success','message' => 'OTP Sent Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed','message' => 'Invalid Credentials'], 401);
        }
    }

    public function verifyOTPCode(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();
        if($count == 1 ){
            // database otp update
            User::where('email', '=', $email)->update(['otp' => '0']);
            // password reset token issue
            $token = JWTToken::createTokenResetPassword($email);
            return response()->json(['status' =>'success','message' => 'OTP Verified Successfully', 'token' => $token], 200);
//            $user = User::where('email', '=', $email)->first();
//            if($user->otp == $otp){
//                return response()->json(['status' =>'success','message' => 'OTP Verified Successfully'], 200);
//            } else {
//                return response()->json(['status' => 'failed','message' => 'Invalid OTP'], 401);
//            }
        } else {
            return response()->json(['status' => 'failed','message' => 'Invalid Credentials'], 401);
        }
    }

    public function resetPassword(Request $request){
        try {
            $email = $request->header('email');
            // new password
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password'=>  bcrypt($password)]);
            return response()->json(['success' => true, 'message' =>'Password updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

}
