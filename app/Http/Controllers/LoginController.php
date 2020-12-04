<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class LoginController extends Controller
{
    private $nameToken = 'admin';

    /**
     * @OA\Schema(
     *   schema="Login",
     *   @OA\Property(
     *     property="email",
     *     type="string"
     *   ),
     *   @OA\Property(
     *     property="password",
     *     type="string"
     *   )
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/login",
     *     @OA\Response(response="200", description="Login User"),
     *     tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Login")
     *      )
     *     ),
     * )
     */
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
