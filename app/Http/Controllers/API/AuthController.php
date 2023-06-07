<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class AuthController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(), 
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Doğrulama Hatası!',
                        'errors' => $validateUser->errors()
                    ],
                    401
                );
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Kullanıcı adı yada şifre hatalı! Lütfen Tekrar Deneyiniz.',
                    ], 
                    401
                );
            }

            $user = User::where('email', $request->email)->firstOrFail();
            $createToken = $user->createToken('SessionID')->plainTextToken;
            $token = explode('|', $createToken);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Kullanıcı girişi başarılı.',
                    'token' => $token[1]
                ],
                200
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage()
                ],
                500
            );
        }
    }
}