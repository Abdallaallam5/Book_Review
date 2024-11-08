@extends('layouts.app')
 @section('content')
 <div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome, {{Auth::user()->name}}                        
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if (Auth::user()->image != "")
                        <img src="{{asset('uploads/profile/'.Auth::user()->image)}}" class="img-fluid rounded-circle" alt="Luna John" style="width: 150px; heaight:150px;">
                        
                    @endif
                                                    
                    </div>
                    <div class="h5 text-center">
                        <strong>{{Auth::user()->name}}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header  text-white">
                    Navigation
                </div>
@include('layouts.sidbar')
            </div>
        </div>
        <div class="col-md-9">
            @include('layouts.messages')
            <div class="card border-0 shadow">
                
                <div class="card-header  text-white">
                    Edit My_Review
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <form action="{{route('update.my_review',$review->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                       <label for="book" class="form-label">Book : <strong>{{$review->book->title}} </strong></label>
<div>

</div>
                         
                       <label for="review" class="form-label">review</label>
                        <input type="text" class="form-control @error('review') is-invalid @enderror" placeholder="review" name="review" id="review" value="{{$review->review}}"/>
                        @error('review') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror


                    <div class="mb-3">
                        <label for="author" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror">
                            
                            <option @if ($review->rating==1) selected @endif value="1">1</option>  
                            <option @if ($review->rating==2) selected @endif value="2">2</option>  
                            <option @if ($review->rating==3) selected @endif value="3">3</option>  
                            <option @if ($review->rating==4) selected @endif value="4">4</option>  
                            <option @if ($review->rating==5) selected @endif value="5">5</option>  
                        </select>
                        @error('status') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>


                    <button class="btn btn-primary mt-2" type="submit">Update</button>
                </form>
                      
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection
