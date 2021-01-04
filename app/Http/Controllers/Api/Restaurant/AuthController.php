<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\restLogin;
use App\Http\Requests\restRegister;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{


    // Restaurant Register
    function register(restRegister $request)
    {
        try {
            $record = Restaurant::create($request->all());
            $record->api_token = Str::random(60); //api_Token
            $record->save();
            if ($request->category_id) {
                $record->categories()->attach($request->category_id);
            }
            return jsonResponse('1', 'Client Added Successfully', [
                'api_token' => $record->api_token,
            ]);
        } //Try end
        catch (\Exception $e) {
            return jsonResponse('0', 'Failed , Try Again');
        } //catch end

    } //register end


    //Restaurant Login
    function login(restLogin $request)
    {

        try {
            $client = Restaurant::where('email', $request->email)->first();

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
    function resetPassword(Request $request)
    {
        $client = Restaurant::where('email', $request->email)->first();
        if ($client) {
            $pin_code = rand(11111, 99999);
            $update = $client->update(['pin_code' => $pin_code]);
            if ($update) {
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
    }//end resetPassword

    // new-password
    function newPassword(Request $request)
    {
        try {
            $client = Restaurant::where('pin_code', $request->pin_code)
            ->where('pin_code', '!=', 0)
            ->first();
        if ($client) {
            $update = $client->update(['pin_code' => null,'password'=>$request->password]);
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

    public function editProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = auth('restaurant')->user();
            $client->update($request->except('api_token','pin_code'));
            if ($request->category_id) {
                $request->user()->categories()->sync($request->category_id);
            }
            DB::commit();
            return jsonResponse('1', 'Profile updated successfully');
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'Something wrong Happend , try again latter');
        }

    }

    //logout
    function logout(){
        try {
            DB::beginTransaction();
            if (auth()->user()) {
                $client = auth()->user();
                $client->api_token = null;
                $client->save();
                DB::commit();
                return jsonResponse('1','logout Succeed');
            }
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0','logout Failed');
        }

        }
}
