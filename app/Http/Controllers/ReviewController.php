<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(Request $request){
        $review=Review::with('book','user')->orderBy('created_at','DESC');
if(!empty($request->keyword) ){
    $review=$review->where('review','like','%'.$request->keyword.'%');
}

        $review=$review->paginate(10);
        return view('review.index',[
            'reviews'=>$review
        ]);
    }

    public function edit($id){
        $review= Review::findOrFail($id);
        
        return view('review.edit',[
            'review'=>$review
        ]);

    }


    public function updatereview($id,Request $request){
        $review= Review::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'review'=> 'required',
            'status'=> 'required',
        ]);
        if ($validator->fails()){
            return redirect()->route('edit.reviews',$id)->withInput()->withErrors($validator);
        }
        $review->review=$request->review;
        $review->status=$request->status;
        $review->save();

        session()->flash('success','Your review updated successfully');
        return redirect()->route('reviews');

    }

    public function destroy(Request $request)
    {
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
                
            ]);

        }
    }
    public function myreview(Request $request){
        $review=Review::with('book')->where('user_id',Auth::user()->id);
        $review=$review->orderBy('created_at','DESC');


        if (!empty($request->keyword)) {
            $review = $review->where('review', 'like', '%' . $request->keyword . '%');
        
            
            $reviewcount = $review->count()->get();
        
            if ($reviewcount == 0) {
                session()->flash('error', 'Your review not found');
            }
        }
        $review=$review->paginate(10);

        return view('account.myreview',[
            'reviews'=>$review,
            
        ]);


    }
}
