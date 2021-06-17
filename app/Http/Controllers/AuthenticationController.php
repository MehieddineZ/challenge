<?php
/*
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function user(){
        return 'Authenticated User';
    }
    public function register(Request $request){
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' =>Hash::make( $request->input('password'))
        ]);
    }
    public function login(Request $request){
      if (!Auth::attempt($request->only('email','password'))){
          return response([
              'message' => 'Invalid credentials'
          ],Response::HTTP_UNAUTHORIZED);
    }
    $user = Auth::user();

    return $user;
}
public function getUsers()
{
    $user = User::all()->toArray();
    return $user;
}
}
*/


    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;
    use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\DB;
    use Tymon\JWTAuth\JWTManager as JWT;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    class AuthenticationController extends Controller
    {

        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (JWTException $e) {

                        return response()->json(['error' => 'could_not_create_token'], 500);

                    }

                    return response()->json(compact('user'));
            }
            public function getUsers()
            {
                $user = User::all()->toArray();
                 return $user;
            }
    }
