<?php

namespace App\Http\Controllers;

use App\Mail\SendPasscode;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Passcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

  public function register(Request $request) {

    $validator = Validator::make($request->all(), [
        'role' => 'required|string',
        'name' => 'required|string',
        'email' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
          'message' => $validator->errors()
      ], 201);
    }

    try {
      Passcode::where('email', $request->email)->where('passcode', $request->passcode)->firstOrFail();
      Passcode::where('email', $request->email)->delete();
    } catch(\Exception $e){
      return response()->json([
          'message' => 'Passcode does not match.'
      ], 500);
    }

    $monthLetter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

    $currentMonth = Carbon::now()->month;

    $hav_id = 'HAV' . date('Y') . $monthLetter[$currentMonth] . (User::max('id') + 1);

    $verify_user = User::where('role', $request->role)->where('email', $request->email)->get();
    
    if(count($verify_user)>0){
      return response()->json([
          'message' => 'User already registered, try to log in.'
      ], 500);
    }

    DB::beginTransaction();
    try{
      $user = new User();
      $user->role = $request->role;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->email_verified_at = Carbon::now();
      $user->registration_step = 1;
      $user->status ='Pending';
      $user->hav_id = $hav_id;
      $user->facebook_id = $request->facebook_id;
      $user->google_id = $request->google_id;
      
      if($user->save()){
        $user_details = new UserDetails();
        $user_details->user_id = $user->id;
        $user_details->hav_id = $hav_id;
        $user_details->save();
      }
      DB::commit();
      return response()->json([
          'message' => 'User register successfully.',
          'token' => $user->createToken('Health A Vision Personal Access Client')->accessToken,
          'user' => $user
      ],200);

    } catch(\Exception $e){
      DB::rollBack();
      return response()->json([
          'message' => $e->getMessage()
      ], 500);
    }
  }

  public function login(Request $request){
    $validator = Validator::make($request->all(), [
        'role' => 'required|string',
        'password' => 'required|string',
        'email' => 'required|string'
    ]);

    if ($validator->fails()) {
      return response()->json([
          'message' => $validator->errors()
      ], 201);
    }

    $verify_user = User::where('email',$request->email)->where('role',$request->role)->get();
    
    if(count($verify_user) > 0){

      if($request->isPasscode) {
        $check_passcode = Passcode::where('email', $request->email)->where('passcode', $request->password)->first();
        if($check_passcode) {
          return response()->json([
            'message' => 'User logged in successfully.',
            'token' => $verify_user[0]->createToken('Health A Vision Personal Access Client')->accessToken,
            'user' => $verify_user[0]
          ],200);
        } else {
          return response()->json([
            'message' => 'Passcode does not match.'
          ], 500);
        }
      } else {

        if(Hash::check($request->password,$verify_user[0]->password)){
          return response()->json([
            'message' => 'User logged in successfully.',
            'token' => $verify_user[0]->createToken('Health A Vision Personal Access Client')->accessToken,
            'user' => $verify_user[0]
          ],200);
        } else {
          return response()->json([
            'message'=>'Invalid Credentials ! Please check password again.'
          ], 500);
        }
      }
    } else {
      return response()->json([
        'message'=>'User does not exist.'
      ], 500);
    }
  }
}
