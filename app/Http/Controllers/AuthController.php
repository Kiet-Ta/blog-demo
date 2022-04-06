<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AuthController extends Controller
{
    /**
     * @OA\Tag(
     *     name="auth",
     *     description="Operations about authentication"
     * )
     */

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"auth"},
     *     summary="Logs user into system",
     *     operationId="login",
     *     @OA\RequestBody(
     *         description="Login by email, password",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="example@gmail.com",
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password",
     *             ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user",
     *                  type="object",
     *                  ref="#/components/schemas/User",
     *              ),
     *              @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *                  example="bearer",
     *              ),
     *              @OA\Property(
     *                  property="expires_in",
     *                  type="integer",
     *                  example="3600",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Wrong email/password",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthorized",
     *              ),
     *          )
     *      )
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($request->email)->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
        } else {
            throw new AuthenticationException('Invalid email or password');
        }

        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"auth"},
     *     summary="Logs out current logged in user session",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthenticated",
     *              ),
     *         )
     *     )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Log out succesfully']);
    }
}
