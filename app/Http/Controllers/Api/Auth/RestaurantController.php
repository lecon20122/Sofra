<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\restRegister;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\restLogin;

class RestaurantController extends Controller
{
    function register(restRegister $request){
        // try {
            $record = Restaurant::create($request->all());
            $record->api_token = Str::random(60); //api_Token
            $record->categories()->attach($request->category_id);
            $record->save();
            return jsonResponse('1','Client Added Successfully',[
                'api_token'=>$record->api_token,
                'client' => $record
            ]);
        // }//Try end
        // catch (\Exception $e) {
        //     return jsonResponse('0','Failed , Try Again');
        // }//catch end

    }//register end

    function login(restLogin $request)
    {

        $client = Restaurant::where('email',$request->email)->first();

        if ($client)
        {
            if ($client) {
                if (Hash::check($request->password, $client->password)) {
                    return jsonResponse('1', 'Login Succeed', [
                        'api_token' => $client->api_token,
                    ]);
                } else {
                    return jsonResponse('0', 'Password Wrong');
                }
            }
            return jsonResponse('0', 'Client Deactivated, Kindly Contact the Administration');
        }else
        {
            return jsonResponse('0' , 'Client Not Found');
        }
    }

    function logout(){
        try {
            auth('restaurant')->logout();
            return jsonResponse('1','logout Succeed');
        } catch (\Exception $th) {
            return jsonResponse('0','logout Failed');

        }

        }



}//controller end
