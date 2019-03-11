<?php

namespace Postici\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Postici\Models\User;
use StdClass;

class AuthController extends Controller
{
    public function getSignin()
    {
        return view('auth.signin');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        // Custom Authentication
        if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
            return redirect()->back()
                ->with('info', 'Incorrect email or password')
                ->with('info_type', 'danger');
        }

        if ($request->query('continue')) {
            return redirect()->to($request->query('continue'));
        }

        Auth::user()->saveLastSeen();

        return redirect()->route('home')
            ->with('info', 'You are signed in')
            ->with('info_type', 'success');
    }

    public function getSignup()
    {
        return view('auth.signup');
    }

    public function postSignup(Request $request)
    {
        $rules = [
            'firstname' => 'required|alpha_space_dash|max:32',
            'lastname' => 'required|alpha_space_dash|max:32',
            'username' => 'required|alpha_num|min:6|unique:users|max:32|not_in:admin,administrator,Admin,Administrator',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|confirmed|min:6|max:255',
            'gender' => 'in:-1,1,2',
            'birthdate' => 'nullable|date|before:18 years ago',
            'accept_tcs' => 'accepted'
        ];

        $customMessages = [
            'birthdate.date' => 'The birthdate is not a valid date. Format: yyyy-mm-dd',
            'birthdate.before' => 'You must be at least 18 years old',
            'accept_tcs.accepted' => 'You must accept the terms and conditions.',
            'username.not_in' => 'This username is already taken.'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = new StdClass;

        $user->firstname = trim($request->input('firstname'));
        $user->lastname = trim($request->input('lastname'));
        $user->username = trim($request->input('username'));
        $user->email = trim($request->input('email'));
        $user->password = bcrypt($request->input('password'));

        if ($request->has('gender') && $request['gender'] != -1) {
            $user->gender = $request['gender'];
        }

        if ($request->has('birthdate') && trim($request['birthdate'])) {
            $user->birthdate = Carbon::parse($request['birthdate'])->format('Y-m-d');
        }

        User::create((array) $user);

        return redirect()
            ->route('home')
            ->with('info', 'Your account was created you can now sign in')
            ->with('info_type', 'success');
    }

    public function getLogout()
    {
        Auth::user()->saveLastSeen();

        Auth::logout();

        return redirect()->route('auth.signin');
    }
}
