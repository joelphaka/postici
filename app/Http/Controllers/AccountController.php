<?php

namespace Postici\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Postici\Models\Country;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }

    public function edit()
    {
        return view('account.edit');
    }

    public function update(Request $request)
    {
        $rules = [
            'firstname' => 'required|alpha_space_dash|max:32',
            'lastname' => 'required|alpha_space_dash|max:32',
            'gender' => 'in:-1,1,2',
            'birthdate' => 'nullable|date|before:18 years ago',
            'country_id' => 'in:-1,' . implode(',', Country::select('id')->pluck('id')->toArray())
        ];

        $customMessages = [
            'birthdate.date' => 'The birthdate is not a valid date. Format: yyyy-mm-dd',
            'birthdate.before' => 'You must be at least 18 years old'
        ];

        $this->validate($request, $rules, $customMessages);

        Auth::user()->firstname = $request['firstname'];
        Auth::user()->lastname = $request['lastname'];

        if ($request->has('gender')) {
            Auth::user()->gender = ($request['gender'] != -1) ? $request['gender'] : null;
        }

        if ($request->has('birthdate')) {
            if ($request['birthdate']) {
                Auth::user()->birthdate = Carbon::parse($request['birthdate'])->format('Y-m-d');
            } else {
                Auth::user()->birthdate = null;
            }
        }

        if ($request->has('country_id')) {
            Auth::user()->country_id = ($request['country_id'] != -1) ? $request['country_id'] : null;
        }

        Auth::user()->save();

        return redirect()->route('account.edit')
            ->with('info', 'Your details were successfully updated')
            ->with('info_type', 'success');
    }

    public function security()
    {
        return view('account.security');
    }
}
