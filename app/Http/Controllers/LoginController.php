<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ValidationMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class LoginController extends Controller
{
    use ValidationMake;
    private $nameToken = 'admin';
    private $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required|min:3'
    ];

    /**
     * @OA\Schema(
     *   schema="login",
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
     *          @OA\JsonContent(ref="#/components/schemas/login")
     *      )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $valid = $this->valid($request, $this->rules);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 200);
        }
        $email = $request->get('email');
        $password = $request->get('password');
        $user = User::where('email', $email)->first();
        if ($this->isValid($user, $password)) {
            $accessToken = $user->createToken($this->nameToken)->accessToken;
            return response()
                ->json($this->token($accessToken));
        }
        return response('User invalid', 404);
    }

    protected function isValid($user, $password)
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
