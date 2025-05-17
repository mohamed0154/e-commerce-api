<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Models\Admin;
use App\Traits\GetResponseJson;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    use GetResponseJson;
    
    public function login(LoginAdminRequest $request){
       
        

        $admin=Admin::where('email',$request->email)->first();
      
        if(!$admin || !Hash::check($request->password,$admin->password)){
            return $this->setErrorMessage('wrong with Credintals');
        }

        $token= 'Bearer ' . $admin->createToken($admin->name, ['role:admin'])->plainTextToken;
        $admin->token = $token;

        return $this->setData($admin,'Authenticated');
        
    }
}
