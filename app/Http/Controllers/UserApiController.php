<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function ShowUsers($id = null)
    {
        if ($id == '') {
            $users = User::get();
            return response()->json(['users' => $users], 200);
        } else {
            $users = User::findOrFail($id);
            return response()->json(['users' => $users], 200);
        }
    }

    public function AddUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules=[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];
            $custoMessage =[
                'name.required'=> "Name is required",
                'email.required'=> "Email is required",
                'email.email'=> "Email must be a vaild email",
                'password.required'=> "Password is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user-> save();
            $message = "User Successfully Added!!";
            return response()->json(['message'=>$message],201);
        }
    }
    public function AddMultipleUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules=[
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];
            $custoMessage =[
                'users.*.name.required'=> "Name is required",
                'users.*.email.required'=> "Email is required",
                'users.*.email.email'=> "Email must be a vaild email",
                'users.*.password.required'=> "Password is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            foreach($data['users'] as $user){
                $multiUser = new User();
                $multiUser->name = $user['name'];
                $multiUser->email = $user['email'];
                $multiUser->password = bcrypt($user['password']);
                $multiUser-> save();
                $message = "Users Successfully Added!!";
            }
            return response()->json(['message'=>$message],201);
        }
    }

    public function updateUserDetails(Request $request,$id){
        if($request->isMethod('put')){
            $data = $request->all();
            $rules=[
                'name' => 'required',
                'password' => 'required',
            ];
            $custoMessage =[
                'name.required'=> "Name is required",
                'password.required'=> "Password is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user =  User::findOrFail($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user-> save();
            $message = "User Successfully Updated!!";
            return response()->json(['message'=>$message],202);
        }
    }

    public function updateSingleRecords(Request $request,$id){
        if($request->isMethod('patch')){
            $data = $request->all();
            $rules=[
                'name' => 'required',
            ];
            $custoMessage =[
                'name.required'=> "Name is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user =  User::findOrFail($id);
            $user->name = $data['name'];
            $user-> save();
            $message = "User Successfully Updated For Single Record!!";
            return response()->json(['message'=>$message],202);
        }
    }

    public function deleteUser($id = null){
      User::findOrFail($id)->delete();
      $message = "User Successfully Deleted!!";
      return response()->json(['message'=>$message],200);
    }

    public function deleteUserWithJson(Request $request){
        if($request->isMethod('delete')){
            $data = $request->all();
            User::where('id',$data['id'])->delete();
            $message = "User Successfully Deleted!!";
            return response()->json(['message'=>$message],200);
        }
    }

    public function deleteMultipleUser($ids){
        $ids = explode(',',$ids);
        User::whereIn('id',$ids)->delete();
        $message = "User Successfully Deleted!!";
        return response()->json(['message'=>$message],200);
    }

    public function deleteMultipleUserWithJson(Request $request){

        $header = $request->header('Authorization');
        if($header == ''){
            $message = "Authorization is required";
            return response()->json(['message'=>$message],200);
        }else{
            if($header == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRlc3RpbmciLCJpYXQiOjE1MTYyMzkwMjJ9.QSa47Ey79UsgykuOnBYmawbPFCORRC9Q-kTw-o2hptc'){
                if($request->isMethod('delete')){
                    $data = $request->all();
                    User::whereIn('id',$data['ids'])->delete();
                    $message = "User Successfully Deleted!!";
                    return response()->json(['message'=>$message],200);
        
                }
            }else{
                $message = "Authorization dose not match";
                return response()->json(['message'=>$message],200);
            }
        }

    }

    public function registerUserPassport(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules=[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];
            $custoMessage =[
                'name.required'=> "Name is required",
                'email.required'=> "Email is required",
                'email.email'=> "Email must be a vaild email",
                'password.required'=> "Password is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user-> save();

            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $user = User::where('email',$data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email',$data['email'])->update(['access_token'=>$access_token]);
            $message = "User Successfully Registered!!";
            return response()->json(['message'=>$message,'access_token'=>$access_token],201);
            }else{
                $message = "OPPS! Something went worng";
                return response()->json(['message'=>$message],422);
            }
        }
    }
    public function loginUserPassport(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules=[
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ];
            $custoMessage =[
                'email.required'=> "Email is required",
                'email.email'=> "Email must be a vaild email",
                'email.exists'=> "Email dose not exists",
                'password.required'=> "Password is required",
            ];
            $validator = Validator::make( $data,$rules,$custoMessage );

            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $user = User::where('email',$data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email',$data['email'])->update(['access_token'=>$access_token]);
            $message = "User Successfully Login!!";
            return response()->json(['message'=>$message,'access_token'=>$access_token],201);
            }else{
                $message = "Invalid emai or password";
                return response()->json(['message'=>$message],422);
            }
        }
    }
}
