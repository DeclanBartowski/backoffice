<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RestoreRequest;
use App\Models\Restores;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $loginRequest, UserService $userService): \Illuminate\Http\JsonResponse
    {
        return $userService->login($loginRequest->all());
    }

    public function logout(UserService $userService): \Illuminate\Http\RedirectResponse
    {
        return $userService->logout();
    }

    public function register(RegisterRequest $registerRequest, UserService $userService) {
        $status = $userService->register($registerRequest->all());
        if($status) {
            return redirect()->route('auth')->with('success', true);
        } else {
            return redirect()->back();
        }
    }

    public function restore(RestoreRequest $restoreRequest, UserService $userService) {
        $status = $userService->restore($restoreRequest->all());
        if($status) {
            return redirect()->route('auth')->with('success', true);
        } else {
            return redirect()->back();
        }
    }

    public function changeEmail(ChangeEmailRequest $changeEmailRequest, UserService $userService)
    {
        $status = $userService->sendLink($changeEmailRequest->all());
        $redirect = redirect()->back();
        return ($status) ? $redirect->with('success', true) : $redirect->withErrors(['create' => false]);

    }

    public function activeEmail(Restores $code, UserService $userService)
    {
        $status = $userService->changeEmail($code);
        $redirect = redirect()->route('profile');
        return ($status) ? $redirect->with('email-active', true) : $redirect->with('email-error', true);
    }

    public function users(Request $request, UserService $userService){
        \SEOMeta::setTitle('Список пользователей');

       if($request->has('sort_field') && $request->has('sort_order')) {
           $userService->setSortParams($request->get('sort_field'), $request->get('sort_order'));
       }

        return view('users.users', [
            'data' => $userService->getUsers(),
            'sort' => $userService->getSortParams()
        ]);
    }
}
