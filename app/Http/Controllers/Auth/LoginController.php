<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(Request $request){
        try{
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)){
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Unauthorized',
                    
                ]);
            }

            $user =  User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password, [])){
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Password Match',
                    
                ]);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);

        }catch(Exception $error){
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in login',
                'error' => $error,
            ]);
        }
    }

    public function getApi(Request $request){
    	$token    = '1|vPcr38WXqPEAa03fxYjLccAXpT5jRPB419rOEuPb';
        $token    = 'Bearer ' . $token;
        $client3  = new Client(['headers' => ['content-type' => 'application/json', 'Accept' => 'application/json', 'Authorization' => $token], 'http_errors' => false]);
        $response = $client3->get('http://localhost/demo/public/index.php/api/user');
        $result   = $response->getBody()->getContents();
        $data     = json_decode($result);
        print_r($data);
    }
}