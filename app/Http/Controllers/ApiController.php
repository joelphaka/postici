<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2019/01/09
 * Time: 20:30
 */

namespace Postici\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Postici\Models\User;
use Postici\Models\Country;

class ApiController extends Controller
{
    public function getCountries()
    {
        return response()->json([
            'data' => Country::orderBy('name', "ASC")->get()
        ]);
    }

    public function searchPeople(Request $request)
    {
        $q = $request->input('q');

        if (!$q) {
            return response()->json([]);
        }

        $people = User::select([
            'id',
            'username',
            'firstname',
            'lastname',
            'country_id'
        ])->where(DB::raw("CONCAT(firstname,' ',lastname)"), 'LIKE', "%{$q}%")
            ->orWhere('firstname', 'LIKE', "%{$q}%")
            ->orWhere('lastname', 'LIKE', "%{$q}%")
            ->orWhere('username', 'LIKE', "%{$q}%");

        $people = $people->get()->map(function ($p) {
            $p->profile_url = route('user.profile', ['username' => $p->username]);
            return $p;
        });

        return response()->json($people);
    }
}