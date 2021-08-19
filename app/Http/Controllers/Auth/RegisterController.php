<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\EmailService;
use App\Models\EmailSMSLimitRate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Alert;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('installed');
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
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $this->user_register();

    }

    public function user_register(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      
        $slug = Str::slug($request->name);
        $checkUser = User::where('email', $request->email)->count();
        $checkSlug = User::where('slug', $slug)->count();

        
        if ($checkUser == 0) {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->slug = $slug . rand(100, 1000);
        $user->visitor = $_SERVER['REMOTE_ADDR'];
        $user->save();

        $email_sms_rate = new EmailSMSLimitRate();
        $email_sms_rate->owner_id = $user->id;
        $email_sms_rate->email = 0;
        $email_sms_rate->sms = 0;
        $email_sms_rate->from = Carbon::now();
        $email_sms_rate->to = Carbon::now();
        $email_sms_rate->status = true;
        $email_sms_rate->save();

        $gmail = new EmailService();
        $gmail->owner_id = $user->id;
        $gmail->provider_name     = 'gmail';
        $gmail->driver     = null;
        $gmail->host       = null;
        $gmail->port       = null;
        $gmail->username       = null;
        $gmail->password       = null;
        $gmail->encryption      = null;
        $gmail->from       = null;
        $gmail->from_name      = null;
        $gmail->sendmail      = '/usr/sbin/sendmail -bs';
        $gmail->pretend      = 0;
        $gmail->active      = 1;
        $gmail->save();

        Alert::success(translate('Success'), translate('Try Login'));

        return redirect()->route('dashboard');
        }else{
            Alert::error(translate('Whoops'), translate('User Already Exist'));
            return back();
        }

        
    }


}
