<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\PasswordResetJob;
use App\Jobs\VerifyUserJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Str;
    use Illuminate\Support\Facades\Mail;
class AuthController extends Controller
{
      /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','veriyEmail','forgotPassword','updatePassword']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        //  dd($request->all());
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // dd('asdf');
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password),
                    'slug'=> Str::random(5),
                    'token' => Str::random(10),
                    'status' => 0,
                    'verify' => 0,
                    'about' => $request->about,

                    ]
                ));


                if($user){

                    $details=[
                        'name' => $user->name,
                        'email' => $user->email,
                        'token' => $user->token

                    ];
                    // Mail::to("rnrashedrn@gmail.com")->send($user);
                    dispatch(new VerifyUserJobs($details));
                    // Mail::to($details['email'])->send(new \App\Mail\VerifyUserMail($details));
                }
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    public function verifyEmail($token,$email){
        $user = User::where(['token' => $token,'email' => $email])->first();
        if($user){
            $user->email_verified_at = now();
            $user->save();
            return response()->json([
                'message' => 'Email Verified Successfully',
                'user' => $user,
            ]);
        }
        else{
            return response()->json([
                'message' => 'Email Verified Failed'
            ]);
        }
    }
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       try{
        $user =User::where('email', $request->email)->first();
        if($user){
            $token = Str::random(10);
            $details =[
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ];
            if(dispatch(new PasswordResetJob($details))){
                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'password reset mail send to your mail'
                ]);
            }
        }else{
            return response()->json([
                'message' => 'invalid email address',
                'status' => false,
            ]);

        }
       }
       catch(\Throwable $th){
        return response()->json([
            'message' => $th->getMessage(),
            'status' => false,
        ]);
       }
    }
    public function checkToken($token,$email){
        $user = DB::table('password_resets')->where(['email' => $email, 'token' => $token])->first();
        if(!$user){
            return response()->json([
                'status' => false,
                'messsage' =>'Email or token not found'
         ]);
      }
      else{
        return  redirect()->to(route('updatePassword',['email' => $email,'token' => $token]));
      }
    }
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' =>'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       if(!$user = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first()){
           return response()->json([
               'messsage' =>'Email or token not found'
        ]);
     }
     else{
        $data = User::where('email',$request->email)->first();
        $data->password = Hash::make($request->password);
        $data->save();
        DB::table('password_resets')->where('email',$data->email)->delete();
        return response()->json([
            'message' => 'Password Updated'
        ]);

     }

    }
}
