<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class AccountController extends Controller
{
    //show user register page
    public function registeration(){
return view('front.acc.register');
        
    }
    //validation for register
    public function ProcessRegistration(Request $req){
        $validator=Validator::make($req->all(),[

'name'=>'required',
     'email'=>'required|email|unique:users,email',
     'password'=>'required|min:5|same:confirm_password', 
     'confirm_password'=>'required',      
        ]);
if($validator->passes()){
    $user=new User();
    $user->name=$req->name;
    $user->email=$req->email;

    $user->password=$req->password;

    $user->save();
    session()->flash('success', 'You have registered successfully.');
    return response()->json([
        'status'=>true,
       
        ]);
} 
else{
return response()->json([
'status'=>false,
'errors'=>$validator->errors()
]);
    
}
        
    }
//show user logout page
    public function logout(){
Auth::logout();
        return redirect()->route('acc.login');
    }
     //show user login page
    public function login(){

        return view('front.acc.login');
    }
//show user profile page
    public function profile(){
$id=Auth::user()->id;
$user=User::find($id);
        return view('front.acc.profile',['user'=>$user]);
    }
    public function Processauth(Request $req){
$validator=Validator::make($req->all(),[
'email'=>'required|email', 
'password'=>'required',
    
]);
   
if($validator->passes()){
   if(Auth::attempt(['email'=>$req->email,'password'=>$req->password])){
    return redirect()->route('acc.profile');

   }
   else{
    return redirect()->route('acc.login')->with('error','Either Email/Password is incorrect');
   }

}

else{
return redirect()->route('acc.login')->withErrors($validator)->withInput($req->only('email'));
    
}


}
public function updateprofile(Request $req){
    $id=Auth::user()->id;

$validator=Validator::make($req->all(),['name'=>'required|min:5|max:20','email'=>'required|email|unique:users,email,'.$id.',id',

]);

if($validator->passes()){

    $user=User::find($id);
    $user->name=$req->name;
    $user->email=$req->email;
    $user->mobile=$req->mobile;

    $user->designation=$req->designation;
    $user->save();
    session()->flash('success','Profile updated succesfully');  
    return response()->json(['status'=>true,'errors'=>[]]);
}else{
return response()->json(['status'=>false,'errors'=>$validator->errors()]);
    
}
    
}
    public function updateprofilepic(Request $req){

// dd($req->all());
   $validator=Validator::make($req->all(),['image'=>'required|image']);
   $id=Auth::user()->id;
   if($validator->passes()){
$image=$req->image;
$ext=$image->getClientOriginalExtension();
    $imageName=$id.'-'.time().'.'.$ext;
    $image->move(public_path('/profile-pics/'),$imageName);
$sourcepath=public_path('/profile-pics/'.$imageName);

$manager = new ImageManager(new Driver());

// create new image instance with 800 x 600 (4:3)
$image = $manager->read($sourcepath);

// scale to fixed height
$image->cover(150,150);
$image->toPng()->save(public_path('/profile-pics/thumb/'.$imageName));
File::delete(public_path('/profile-pics/thumb/'.Auth::user()->image));
File::delete(public_path('/profile-pics/'.Auth::user()->image));
User::where('id',$id)->update(['image'=>$imageName]);
session()->flash('success','Profile Picture updated Successfully');
return response()->json(['status'=>true,'errors'=>[]]);


}else{

    return response()->json([ 'status'=>false,'errors'=>$validator->errors()]);

    
   }
    }
}