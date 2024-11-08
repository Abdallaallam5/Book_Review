<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    public function register(){
        return view('account.register');
    }

    public function proccessregister(Request $request){
        $validator= Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:5',
            'password_confirmation'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->route('register')->withInput()->withErrors($validator);
        }
        $user= new User();
        $user->name =$request->name;
        $user->email =$request->email;
        $user->password =$request->password;
        $user->save();
        return redirect()->route('login')->with('success','you have registerd successfully');
    }

    public function login(){
        return view('account.login');
    }
    public function proccesslogin(Request $request){
        $validator= Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->route('login')->withInput()->withErrors($validator);
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect()->route('profile');

        }else{
            return redirect()->route('login')->with('error','email or password is invalid');
        }
    }
    public function profile(){
        $user=User::find(Auth::user()->id);

        return view('account.profile',[
            'user' => $user,
        ]);
    }
    public function updateprofile(Request $request){
        $rules= [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.Auth::user()->id.',id',
            
        ];
        if(!empty($request->file('image'))){
            $rules['image'] = 'image|mimes:jpg,jpeg,png,gif|max:2048' ;
        }
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('profile')->withInput()->withErrors($validator);
        }

        $user=User::find(Auth::user()->id);
        $user->name =$request->name;
        $user->email =$request->email;
        $user->save();


        if(!empty($request->image)){
       
        $image=$request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagename=time().'.'.$ext;
        $image->move(public_path('uploads/profile'),$imagename);


        $user->image =$imagename;
        $user->save();


 
        }
        return redirect()->route('profile')->with('success','you have updated profile');
    }


    public function logout(){
        Auth::logout();
        return view('account.login');
        }

        public function editreview($id){

            $review=Review::where([
                'id'=>$id,
                'user_id'=>Auth::user()->id
            ])->with('book')->first(); 


            return view('my_reviews.edit',compact('review'));


        }
        public function updatemyreview($id,Request $request){
            $review= Review::findOrFail($id);
            $validator=Validator::make($request->all(),[
                'review'=> 'required',
                'rating'=> 'required',
            ]);
            if ($validator->fails()){
                return redirect()->route('edit.my_review',$id)->withInput()->withErrors($validator);
            }
            $review->review=$request->review;
            $review->rating=$request->rating;
            $review->save();
    
            session()->flash('success','Your review updated successfully');
            return redirect()->route('my.review');
    
        }

        public function deletereview(Request $request){
            $review = Review::find($request->id);  
    
        if (!$review) {
            session()->flash('error','Your review not found');
            return response()->json([
                'status' => false,
                
            ]);
        }else{
            $review->delete();

            session()->flash('success','Your review deleted successfully');
            return response()->json([
                'status' => true,
                'message'=>'Review Deleted successfully'
            ]);
        }
}
}
