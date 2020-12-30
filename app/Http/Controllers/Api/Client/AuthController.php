<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPassword;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Restaurant Register
    public  function register(Request $request)
    {
        try {
        DB::beginTransaction();
        $record = Client::create($request->all());
        $record->api_token = Str::random(60); //api_Token
        $record->save();
        DB::commit();
        return jsonResponse('1', 'Client Added Successfully', [
            'api_token' => $record->api_token,
        ]);
        } //Try end
        catch (\Exception $e) {
        DB::rollBack();
        return jsonResponse('0', 'Failed , Try Again');
        } //catch end

    } //register end


    //Restaurant Login
    public function login(Request $request)
    {

        try {
            $client = Client::where('email', $request->email)->first();
            if ($client) {
                $client->api_token = Str::random(60);
                $client->save();
                if (Hash::check($request->password, $client->password)) {
                    return jsonResponse('1', 'Login Succeed', [
                        'api_token' => $client->api_token,
                    ]);
                } else {
                    return jsonResponse('0', 'Password Wrong');
                }
            } //if end
            else {
                return jsonResponse('0', 'Client Not Found');
            } //else end
        } catch (\Exception $th) {
            return jsonResponse('0', 'Something wrong happens try again later');
        } //catch end

    } //login end

    //Reset-password
    public function resetPassword(Request $request)
    {
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            $pin_code = rand(11111, 99999);
            $client->update(['pin_code' => $pin_code]);
            $client->save();
            if ($client->pin_code != null) {
                //Send Email
                Mail::to($client->email)
                    ->bcc('silver22726@gmail.com')
                    ->send(new ResetPassword($client));
                return jsonResponse('1', 'Password Reset Code Sent to your Email', [
                    'pin_code' => $pin_code,
                ]);
            } else {
                return jsonResponse('0', 'Something Wrong Happened , try Again Later');
            }
        } else {
            return jsonResponse('0', 'No Email Attached to this Phone');
        }
    } //end resetPassword

    // new-password
    public function newPassword(Request $request)
    {
        try {
            $client = Client::where('pin_code', $request->pin_code)
                ->where('pin_code', '!=', 0)
                ->first();
            if ($client) {
                $update = $client->update(['pin_code' => null, 'password' => $request->password]);
                if ($update) {
                    return jsonResponse('1', 'Password updated successfully');
                }
            } else {
                return jsonResponse('0', 'This Pin Code is not Valid');
            }
        } catch (\Exception $th) {
            return jsonResponse('0', 'Something wrong Happend , try again latter');
        }
    }

    //edit profile
    public function editProfile(Request $request)
    {
        try {

            DB::beginTransaction();
            $client = Auth::guard('client')->user();
            $client->update($request->except('api_token', 'pin_code'));
            DB::commit();
            return jsonResponse('1', 'Profile updated successfully', $client);
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'Something wrong Happend , try again latter');
        }
    }

    //logout
    public function logout()
    {
        try {
            DB::beginTransaction();
            if (auth()->user()) {
                $client = auth()->user();
                $client->api_token = null;
                $client->save();
                DB::commit();
                return jsonResponse('1', 'logout Succeed');
            }
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'logout Failed');
        }
    }

    public function registerToken(Request $request)
    {
        try {
            DB::beginTransaction();
            Token::where('token' , $request->token)->delete();
            $request->user()->tokens()->create($request->all());
            DB::commit();
            return jsonResponse('1', 'Registeration Succeed');
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'logout Failed');
        }

    }
    public function removeToken(Request $request)
    {
        try {
            DB::beginTransaction();
            Token::where('token' , $request->token)->delete();
            DB::commit();
            return jsonResponse('1', 'token removed Succeed');
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('1', 'token removed Failed');
        }
    }
}
