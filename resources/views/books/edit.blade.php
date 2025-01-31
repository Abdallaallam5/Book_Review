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
                <div class="card-body sidebar">
                    <ul class="nav flex-column">
                        @if (Auth::user()->role == "admin")

                        <li class="nav-item">
                            <a href="book-listing.html">Books</a>                               
                        </li>
                        <li class="nav-item">
                            <a href="reviews.html">Reviews</a> 
                                                         
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="profile.html">Profile</a>                               
                        </li>
                        <li class="nav-item">
                            <a href="my-reviews.html">My Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="change-password.html">Change Password</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{route('logout')}}">Logout</a>
                        </li>                           
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @include('layouts.messages')
            <div class="card border-0 shadow">
                
                <div class="card-header  text-white">
                    Edit Book
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <form action="{{route('update.book',$book->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                       <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" value="{{$book->title}}"/>
                        @error('title') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control @error('auther') is-invalid @enderror" placeholder="Author"  name="auther" value="{{$book->auther}}" id="author"/>
                        @error('auther') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" alue="{{$book->description}}" placeholder="Description" cols="30" rows="5"></textarea>
                        @error('description') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"  name="image" id="image"/>
                        @error('image') 
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                        @if (!empty($book->image))
                        <img src="{{asset('uploads/profile/'.$book->image)}}" alt="{{$book->title}}" style="width: 150px; heaight:150px;">
                        @endif
                        
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            
                            <option @if ($book->status==1) selected @endif value="1">Active</option>  
                            
                            
                            <option  @if ($book->status == 0) selected @endif value="0">Block</option>
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