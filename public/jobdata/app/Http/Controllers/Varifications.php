<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Register_User;
use App\Models\Tld_Domain_List;
use App\Models\User_Varification;
use App\Models\Record_Download_Count;

use Illuminate\Cache\RedisStore;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Session;
class Varifications extends Controller
{
    // Checking is email has TLD domain or not
    public function checkEmailTld($email){

        $generalEmailProviders = ["gmail","yahoo"];
        // print_r($generalEmailProviders);
        $domainExt = explode('@', $email);
        $domainExt = explode('.', $domainExt[1]);
        $domainName = explode('.', $domainExt[0])[0];
        $domainExt = $domainExt[1];
        $tldDomainList = Tld_Domain_List::pluck("domain_name")->all();
        // dd($domainName);
        if(!in_array(strtoupper($domainExt),$tldDomainList) || in_array(strtolower($domainName),$generalEmailProviders)){
              return false;
        }

        // For checking is email and domain are real and working.
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);
        $responce = $validator->isValid($email, $multipleValidations); //true/false

        return $responce;
    }

    public function varifyEmail(Request $request, $slug){
        
        $row = User_Varification::where('key','=',$slug)->first();

        $link_expired = Register_User::where([['email', $row->email], ["varified", true]])->first();

        if($row && !$link_expired):
            $request->session()->put('emailVarified', true);
            $request->session()->put('userEmail', $row->email);
            
            if(Register_User::where('email', $row->email)->first()){
                Register_User::where('email', $row->email)->update(["varified" => true]);
            }
            else{
                return "User Not Found";
            }

            return redirect()->route("home", ['welcome' => $row->email]);
        else:
            echo "Invalid Request";
        endif;
    }


    // Sending varification link on business email
    private function sendVarificationEmail($userEmail){

        // Creating unique hashn key for varification
        $hash_key = sha1(time());

        User_Varification::create([
            'email'=> $userEmail,
            'key' => $hash_key
        ]);
        
        if(!Register_User::where('email', $userEmail)->first()){
            Register_User::create([
                'email' => $userEmail,
                'varified' => false,
            ]);
        }

        if(!Record_Download_Count::where('user_email', $userEmail)->first()){
            Record_Download_Count::create([
                'user_email' => $userEmail,
            ]);
        }

        $details = [
            'title' => 'Email Varification',
            'body' => 'https://data.bizprospex.com/jobdata/public/varification/'.$hash_key,
        ];
        
        \Mail::to($userEmail)->send(new \App\Mail\SentEmail($details));
    }

    // Register new user by checking business email and varification
    public function userRegistration(Request $request){

        $userData = $request->all();

        if(!$this->checkEmailTld($userData['userEmail'])){
            return response()->json(["status"=>"failed", "htmlMessage"=>"Must Need Business Email!"], 401);
        }

        $isUserFound = Register_User::where("email","=", $userData['userEmail'])->where("varified", "=", 1)->first();
        if(!$isUserFound):

            $this->sendVarificationEmail($userData['userEmail']);

            return response()->json(["status"=>"success", "htmlMessage"=>"Kindly check your email verification link is sent, kindly click on that link to verify the account"], 200);
        else:

            $request->session()->put('emailVarified', true);
            $request->session()->put('userEmail', $userData['userEmail']);

            return response()->json(["status"=>"success", "htmlMessage"=>"Sucess"], 200);
        endif;
    }

    // Create new admin by signup page
    public function adminRegistration(Request $request){
        $request = $request->all();
        User::create(['name'=> $request['name'],'email'=> $request['email'], 'password' => Hash::make($request['password'])]);
        return redirect()->route('login');
    }

    // Login for admin
    public function adminLogin(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)):
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        else:
            return redirect()->route("login", ['invalid_credentials' => 'Check Credentials']);
        endif;
    }

}