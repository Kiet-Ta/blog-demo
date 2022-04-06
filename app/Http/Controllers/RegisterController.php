<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * @OA\Tag(
     *     name="register",
     *     description="Register new user"
     * )
     */

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"register"},
     *     summary="Register a user",
     *     operationId="registerUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Register by name, email, password",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="example",
     *             ),
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
     *                  property="token",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *                  example="bearer",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="The given data was invalid.",
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="email",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The email has already been taken.",
     *                      )
     *                  )
     *              ),
     *         )
     *     ),
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRequest $request)
    {
        $user = User::create($request->all());

        $token = $user->createToken($request->email)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 201);
    }
}
