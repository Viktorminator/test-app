<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizeRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Modules\Users\Repositories\UserRepository;
use App\Modules\Users\Services\CreateUserService;
use App\Modules\Users\Services\UpdateUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * @param  UserRepository  $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     operationId="registerUser",
     *     tags={"Users"},
     *     summary="Register a new user",
     *     description="Registers a new user with the provided information.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"first_name", "last_name", "email", "phone", "password"},
     *             @OA\Property(property="first_name", type="string", example="John", description="User's first name"),
     *             @OA\Property(property="last_name", type="string", example="Doe", description="User's last name"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
     *             @OA\Property(property="phone", type="string", example="123-456-7890", description="User's phone number"),
     *             @OA\Property(property="password", type="string", format="password", example="secret", description="User's password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="User registered successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"first_name": {"The first_name field is required."}, "last_name": {"The last_name field is required."}, "email": {"The email field is required.", "The email must be a valid email address."}, "phone": {"The phone field is required."}, "password": {"The password field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Server error occurred while processing the request.")
     *         )
     *     ),
     * )
     */

    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     @OA\Property(property="first_name", type="string", example="John", description="User's first name"),
     *     @OA\Property(property="last_name", type="string", example="Doe", description="User's last name"),
     *     @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
     *     @OA\Property(property="phone", type="string", example="123-456-7890", description="User's phone number")
     * )
     */
    /**
     * @param  CreateUserRequest  $request
     * @param  CreateUserService  $service
     * @return JsonResponse
     */
    public function createUser(CreateUserRequest $request, CreateUserService $service): JsonResponse
    {
        $user = $service->create($request->getParams()->all());

        return response()->json($user, 201);
    }


    /**
     * @OA\Post(
     *     path="/api/user/sign-in",
     *     operationId="signInUser",
     *     tags={"Users"},
     *     summary="Sign in a user",
     *     description="Signs in a user with the provided email and password.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
     *             @OA\Property(property="password", type="string", format="password", example="secret", description="User's password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sign-in successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success", description="Status of the response (success/fail)"),
     *             @OA\Property(property="api_token", type="string", example="BClk0zHnoLpx1AgWbpQwrSnQYWiUIJ", description="API key for the signed-in user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Sign-in failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="fail", description="Status of the response (success/fail)")
     *         )
     *     ),
     * )
     */

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\AuthorizeRequest  $request
     * @param  \App\Modules\Users\Services\UpdateUserService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(
        AuthorizeRequest $request,
        UpdateUserService $service
    ): JsonResponse {
        $email = $request->getParams()->get('email');
        $password = $request->getParams()->get('password');
        $user = $this->repository->getByEmail($email);
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'User not found with the provided email'], 401);
        }
        if (Hash::check($password, $user->password)) {
            $apiToken = $service->update($email);
            return response()->json(['status' => 'success', 'api_token' => $apiToken]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/user/recover-password",
     *     operationId="updatePasswordWithTokenPost",
     *     tags={"Users"},
     *     summary="Update password with recovery token",
     *     description="Updates the password using the recovery token sent to the user's email.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "email_token", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
     *             @OA\Property(property="email_token", type="string", example="email_token", description="Recovery token received via email"),
     *             @OA\Property(property="password", type="string", format="password", example="new_secret_password", description="User's new password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Password updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found with the provided email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid recovery token",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid recovery token")
     *         )
     *     )
     * )
     */
    /**
     * @OA\Patch(
     *     path="/api/user/recover-password",
     *     operationId="updatePasswordWithTokenPatch",
     *     tags={"Users"},
     *     summary="Update password with recovery token",
     *     description="Updates the password using the recovery token sent to the user's email.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "email_token", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
     *             @OA\Property(property="email_token", type="string", example="email_token", description="Recovery token received via email"),
     *             @OA\Property(property="password", type="string", format="password", example="new_secret_password", description="User's new password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Password updated successfully"),
     *             @OA\Property(property="api_token", type="string", example="d98PhIQ9PEzza0K5HpsAaoxJam8RXZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found with the provided email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid recovery token",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid recovery token")
     *         )
     *     )
     * )
     */
    /**
     * @param  RecoverPasswordRequest  $request
     * @param  UpdateUserService  $service
     * @return JsonResponse
     */
    public function recoverPassword(
        RecoverPasswordRequest $request,
        UpdateUserService $service
    ): JsonResponse {
        $email = $request->getParams()->get('email');
        $newPassword = $request->getParams()->get('password');
        $token = $request->getParams()->get('email_token');
        $user = $this->repository->getByEmail($email);
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'User not found with the provided email'], 401);
        }
        if ($token == $user->email_token) {
            $token = $service->resetPassword($user, $newPassword);
            $service->resetEmailToken($user);
            return response()->json(['status' => 'success', 'message' => 'Password updated successfully', 'api_token' => $token]);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Invalid recovery token'], 401);
        }
    }
}
