<?php

namespace App\Http\Controllers;

use App\Mail\SendPasscode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Passcode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller
{

  public function sendPasscode(Request $request) {

    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => $validator->errors()->first()
      ], 500);
    }

    $otp = mt_rand(1000,9999);

    try {
      Mail::to($request->email)->send(new SendPasscode($otp));

      Passcode::where('email', $request->email)->delete();
      $passcode = new Passcode();
      $passcode->email = $request->email;
      $passcode->passcode = $otp;
      $passcode->save();

    } catch (Throwable $e) {
      return response()->json([
        'message' => $request->all()
      ], 201);
    }
    return response()->json([
      'message' => 'Passcode sent successfully.'
    ], 200);
  }

  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'role' => 'required|string',
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'passcode' => 'required|string'
    ]);



    if ($validator->fails()) {
      return response()->json([
        'message' => $validator->errors()
      ], 201);
    }else{
    //process the request
    }

    $validate =  $this->getValidationFactory()->make($request->all(), [
      'role' => 'required|string',
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'passcode' => 'required|string'
    ]);

    return response()->json([
      'message' => $validate
    ], 201);

    $user = new User([
      'role' => $request->role,
      'name' => $request->name,
      'email' => $request->email,
      'passcode' => base64_encode($request->password),
      'registration_step' => 1,
      'status' => 'Pending'
    ]);

    $user->save();
    return response()->json([
      'message' => 'Successfully created user!'
    ], 201);
  }
}
