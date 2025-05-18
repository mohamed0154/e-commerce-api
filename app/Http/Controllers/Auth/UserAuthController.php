<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Jobs\SendMails;
use App\Models\User;
use App\Traits\GetResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    use GetResponseJson;
    
    //Register
    public function register(RegisterRequest $request){

        $data = $request->except('password','password_confirmation');
        $data['password']=Hash::make($request->password);
        $user = User::create($data);

        $token= 'Bearer ' . $user->createToken($user->name, ['role:user'])->plainTextToken;
        $user->token = $token;

        return $this->setData($user , 'Authenticated');

    } 


    //Generate Code
    public function sendCode(Request $request){
        $token = $request->header('authorization');

        //generate Code
        $code = rand(11111,99999);
        $code_expired_at = date('Y-m-d H:i:s',strtotime('+2 minutes'));

        $user = Auth::guard('sanctum')->user();
        $user->code = $code;
        $user->code_expired_at = $code_expired_at;
        $user->save();

        //send Mail
        dispatch(new SendMails($user));
       
        $user->token = $token;
        return $this->setData($user,'Success');
        
    }


    //email verification
    public function verifiyEmail(Request $request){

       $request->validate([
        'code'=>'required|integer|digits:5|exists:users,code',
       ]);

       $user = Auth::guard('sanctum')->user();
       $currentDate = date('Y-m-d H:i:s');
      
       if($user->code  == $request->code && $user->code_expired_at > $currentDate){

           $user->email_verified_at = date('Y-m-d H:i:s');
           $user->save();
           return $this->setSuccessMessage('Success',$user);
        }

        return $this->setErrorMessage('Code Is Expired');

    }


    //Login
    public function login(LoginUserRequest $request){

         $user = User::where('email',$request->email)->first();
         
         if(!$user || !Hash::check($request->password,$user->password)){
            return $this->setErrorMessage('wrong with credentials');
         }

         $token = "Bearer " . $user->createToken($user->name,['role:user'])->plainTextToken;
         $user->token = $token;

         return $this->setSuccessMessage('Authenticated',$user);

    }
}
