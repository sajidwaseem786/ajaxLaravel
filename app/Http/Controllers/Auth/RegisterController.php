<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use App\Mail\verifyUserByEmail;

use App\Notifications\MarkdownMailNotification;
use Notification;

use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verifyToken'=>str_random(25),
        ]);

   Notification::send($user,new MarkdownMailNotification);
        return $user;


    }

      public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

       // $this->guard()->login($user);

       auth::logout();

       return redirect ('login')->with('message','Check your email for Authentication');
    }

    public function verifyUser($email,$token){
        
        $user=User::where([
            "email"=>$email,
            "verifyToken"=>$token
        ])->first();
   if($user){
        $user->verifyToken='';
        $user->status=1;

        if($user->save()){
            
      return redirect('login')->with('smessage',"Successfully verified");
        }
        else{
            
      return redirect('login')->with('message',"invalid Token Or Email");
        }
   }
   else{

      return redirect('login')->with('message',"invalid Token Or Email");
   }




    }


}
