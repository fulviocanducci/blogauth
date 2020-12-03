<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class LoginController extends Controller
{
    private $nameToken = 'admin';

    public function index(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $user = User::where('email', $email)->first();
        if ($this->valid($user, $password)) {
            $accessToken = $user->createToken($this->nameToken)->accessToken;
            return response()
                ->json($this->token($accessToken));
        }
        return response('User invalid', 404);
    }

    protected function valid($user, $password)
    {
        return $user && Hash::check($password, $user->password);
    }

    protected function token($accessToken)
    {
        $base = new stdClass;
        $base->accessToken = $accessToken;
        $base->created = now();
        return $base;
    }
}
