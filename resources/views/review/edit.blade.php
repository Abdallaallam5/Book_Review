@extends('layouts.app')
 @section('content')
 <div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidbar')
        </div>
        <div class="col-md-9">
            @include('layouts.messages')
            <div class="card border-0 shadow">
                
                <div class="card-header  text-white">
                    Edit Review
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <form action="{{route('update.reviews',$review->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                       <label for="review" class="form-label">review</label>
                        <input type="text" class="form-control @error('review') is-invalid @enderror" placeholder="review" name="review" id="review" value="{{$review->review}}"/>
                        @error('review') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror


                    <div class="mb-3">
                        <label for="author" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            
                            <option @if ($review->status==1) selected @endif value="1">Active</option>  
                            
                            
                            <option  @if ($review->status == 0) selected @endif value="0">Block</option>
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