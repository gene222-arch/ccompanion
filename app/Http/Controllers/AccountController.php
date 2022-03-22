<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function index()
    {
        return view('app.account', [
            'user' => Auth::user()
        ]);
    }

    public function changePassword(AccountChangePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return Redirect::route('account.index')->with([
            'successMessage' => 'Account password updated successfully.'
        ]);
    }
}
