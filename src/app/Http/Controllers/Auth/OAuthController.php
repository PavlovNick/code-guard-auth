<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Controllers\Auth\ConfirmVerificationCodeAction;
use App\Http\Requests\OAuth\ConfirmAccountVerificationRequest;
use App\Actions\Controllers\Auth\SendForgotPasswordAction;
use App\Http\Requests\OAuth\SendEmailVerificationRequest;
use App\Actions\Controllers\Auth\ConfirmAccessCodeAction;
use App\Http\Requests\OAuth\ConfirmResetPasswordRequest;
use App\Actions\Controllers\Auth\SendVerificationAction;
use App\Http\Requests\OAuth\SendForgotPasswordRequest;
use App\Actions\Controllers\Auth\ResetPasswordAction;
use App\Actions\Controllers\Auth\VerifyAccountAction;
use App\Http\Requests\OAuth\ResetPasswordRequest;
use App\Http\Requests\OAuth\VerifyAccountRequest;
use App\Actions\Controllers\Auth\RegisterAction;
use App\Actions\Controllers\Auth\RefreshAction;
use App\Actions\Controllers\Auth\LogoutAction;
use App\Actions\Controllers\Auth\LoginAction;
use App\Http\Requests\OAuth\RegisterRequest;
use App\Http\Requests\OAuth\RefreshRequest;
use App\Http\Requests\OAuth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Exception;

class OAuthController extends Controller
{

    public function register(
        RegisterRequest        $request,
        RegisterAction         $register,
        SendVerificationAction $sendMail
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $user = $register->handle($data);

            if(!$user)
            {
                return $this->httpInternalServerError('Error creating user.');
            }

            $sendMail->handle($user);

            return $this->httpOK('User created, check email address.');
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Error creating user.');
        }
    }

    public function login(
        LoginRequest    $request,
        LoginAction     $action
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $result = $action->handle($data['email'], $data['password']);

            if(!$result)
            {
                return $this->httpUnprocessableEntity('The password is incorrect.');
            }

            return $this->httpOK('You are successfully logged in.', $result);
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Sign in error.');
        }
    }

    public function logout(LogoutAction $action): JsonResponse
    {
        try
        {
            $result = $action->handle();

            if(!$result)
            {
                return $this->httpUnauthorized('Unauthorised.');
            }

            return $this->httpOK('You are successfully logged out.');
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Log out error.');
        }
    }

    public function refreshToken(
        RefreshRequest $request,
        RefreshAction  $action
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $result = $action->handle($data);

            if(!$result)
            {
                return $this->httpUnprocessableEntity('Invalid refresh token.');
            }

            return $this->httpOK('Access data updated successfully.', $result);
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Refresh token error.');
        }
    }

    public function sendEmailVerification(
        SendEmailVerificationRequest    $request,
        SendVerificationAction          $action
    ): JsonResponse
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email']);

        if($user?->hasVerifiedEmail())
        {
            return $this->httpForbidden('This email address has already been verified.');
        }

        try
        {
            $action->handle($user);
            return $this->httpOK('Code sent successfully, please check your mail.');
        }
        catch(Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Failed to send code, please try again later.');
        }
    }

    public function confirmAccountVerificationCode(
        ConfirmAccountVerificationRequest   $request,
        ConfirmVerificationCodeAction       $action
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $user = User::whereEmail($data['email']);

            $code = $action->handle($user, $data['code']);

            if(!$code)
            {
                return $this->httpUnprocessableEntity('Invalid code.');
            }

            return $this->httpOK(
                'The account verification code is valid.',
                ["access_code" => $code->body()]
            );
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Failed to verify verification code.');
        }
    }

    public function verifyAccount(
        VerifyAccountRequest    $request,
        ConfirmAccessCodeAction $confirmCodeAction,
        VerifyAccountAction     $verifyAccountAction
    ): JsonResponse
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email']);

        if($user?->hasVerifiedEmail())
        {
            return $this->httpForbidden('The user under this email address has already been verified and registered.');
        }

        try
        {
            $success = $confirmCodeAction->handle($user, $data['code']);

            if(!$success)
            {
                return $this->httpUnprocessableEntity('Invalid code.');
            }

            $verifyAccountAction->handle($user, $data['password']);

            return $this->httpOK('The account has been successfully verified.');
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Failed to verify account.');
        }
    }

    public function sendForgotPassword(
        SendForgotPasswordRequest   $request,
        SendForgotPasswordAction    $action
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $success = $action->handle($data['email']);

            if(!$success)
            {
                return $this->httpUnprocessableEntity('Invalid code.');
            }

            return $this->httpOK('Code sent successfully, please check your mail.');
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Failed to send code, please try again later.');
        }
    }

    public function confirmResetPasswordCode(
        ConfirmResetPasswordRequest     $request,
        ConfirmVerificationCodeAction   $action
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $user = User::whereEmail($data['email']);

            $code = $action->handle($user, $data['code']);

            if(!$code)
            {
                return $this->httpUnprocessableEntity('Invalid code.');
            }

            return $this->httpOK(
                'The verification code is valid, reset the password.',
                ["access_code" => $code->body()]
            );
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Failed to verify verification code.');
        }
    }

    public function resetPassword(
        ResetPasswordRequest    $request,
        ConfirmAccessCodeAction $confirmCodeAction,
        ResetPasswordAction     $resetPasswordAction
    ): JsonResponse
    {
        $data = $request->validated();

        try
        {
            $user = User::whereEmail($data['email']);

            $success = $confirmCodeAction->handle($user, $data['code']);

            if(!$success)
            {
                return $this->httpUnprocessableEntity('Invalid code.');
            }

            $resetPasswordAction->handle($user, $data['password']);

            return $this->httpOK('Your password has been successfully changed.');
        }
        catch (Exception $exception)
        {
            $this->logException($exception);
            return $this->httpInternalServerError('Changing password error, try again later.');
        }
    }
}
