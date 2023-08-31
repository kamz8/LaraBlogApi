<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Services\ResetPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
|--------------------------------------------------------------------------
| Password Reset Controller
|--------------------------------------------------------------------------
|
| This controller is responsible for handling password reset emails and
| includes a trait which assists in sending these notifications from
| your application to your users. Feel free to explore this trait.
|
*/
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected ResetPasswordService $resetPasswordService;

    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
        $this->middleware('guest');
    }

    /*
     * Send reset password mail
     * */
    public function sendResetLinkEmail(ResetPasswordRequest $request) : JsonResponse {
//        check user with taken email exist
        $user = $this->resetPasswordService->emailExist($request->email);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
//        create token and save in db
        $token = $this->resetPasswordService->createToken($request->email);
//        sand mail to user
        Mail::to($user->email)->queue(new PasswordResetMail($user, $token));

        return response()->json(['message' => "Reset email link sent successfully, please check your inbox"]);
    }
    public function resetPassword(UpdatePasswordRequest $request): JsonResponse
    {
        if (!$this->resetPasswordService->validateEmailAndToken($request->email, $request->token)) {
            return response()->json([
                'message' => 'Invalid token provided.'
            ], 400);
        }

        $this->resetPasswordService->updatePassword($request->email, $request->newPassword);
        $this->resetPasswordService->deleteToken($request->email);

        return response()->json([
            'message' => 'Password has been successfully reset.'
        ], 200);

    }


}
