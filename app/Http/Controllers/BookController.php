<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request){
        $book=Book::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $book->where('title','like','%'.$request->keyword.'%');
        }
        $book=$book->withCount('reviews')->withSum('reviews','rating')->paginate(10);
        return view('books.list',[
            'books' => $book,
        ]);
        

    }

    
    public function create(){
        return view('books.create');
    }

    public function store(Request $request){
        $rules= [
            'title'=>'required|min:5',
            'auther'=>'required|min:3',
            'status'=>'required',
            
        ];
        if(!empty($request->file('image'))){
            $rules['image'] = 'image|mimes:jpg,jpeg,png,gif|max:2048';
        }
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('add.book')->withInput()->withErrors($validator);
        }
        $book=new Book();
        $book->title=$request->title;
        $book->auther=$request->auther;
        $book->description=$request->description;
        $book->status=$request->status;

        $book->save();
        
        if(!empty($request->image)){
       
            $image=$request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imagename=time().'.'.$ext;
            $image->move(public_path('uploads/profile'),$imagename);
    
    
            $book->image =$imagename;
            $book->save();
    
    
     
            }
        return redirect()->route('books')->with('success','you have added book');

    }

    public function edit($id){
        $book = Book::findOrFail($id);
        return view('books.edit',[
            'book' => $book,
        ]);

    }

    public function update($id ,Request $request){
        $rules= [
            'title'=>'required|min:5',
            'auther'=>'required|min:3',
            'status'=>'required',
            
        ];
        if(!empty($request->file('image'))){
            $rules['image'] = 'image|mimes:jpg,jpeg,png,gif|max:2048';
        }
        $validator=Validator::make($request->all(),$rules);
        $book=Book::findOrFail($id);
        if($validator->fails()){
            return redirect()->route('edit.book', $book->id )->withInput()->withErrors($validator);
        }
        
        $book->title=$request->title;
        $book->auther=$request->auther;
        $book->description=$request->description;
        $book->status=$request->status;

        $book->save();
        
        if(!empty($request->image)){
       
            $image=$request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imagename=time().'.'.$ext;
            $image->move(public_path('uploads/profile'),$imagename);
    
    
            $book->image =$imagename;
            $book->save();
    
    
     
            }
        return redirect()->route('books')->with('success','you have updated book');

    }

    public function destroy(Request $request)
{
    $book = Book::find($request->id);  

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'book not found'
        ], 404);
    }

    $imagePath = public_path('uploads/profile/' . $book->image);
    if ($book->image && file_exists($imagePath)) {
        File::delete($imagePath);
    }

    $book->delete(); 

    return response()->json([
        'status' => true,
        'message' => 'book is deleted'
    ]);
}

    


}
