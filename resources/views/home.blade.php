@extends('layouts.app')
 @section('content')

 <div class="container mt-3 pb-5">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h2 class="mb-3">Books</h2>
                <div class="mt-2">
                    <a href="{{route('home')}}" class="text-dark">Clear</a>
                </div>
            </div>
            <div class="card shadow-lg border-0">
                <form action="" method="get">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-11 col-md-11">
                            <input type="text" class="form-control form-control-lg" name="keyword" placeholder="Search by title" value="{{Request::get('keyword')}}">
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-magnifying-glass"></i></button>                                                                    
                        </div>                                                                                 
                    </div>
                </div>
            </form>
            </div>
            <div class="row mt-4">
                @if ($books->isNotEmpty())
                @foreach ($books as $book)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card border-0 shadow-lg">
                        @if (isset($book->image))
                        <a href="{{route('detail',$book->id)}}">
                            <img src="{{asset('uploads/profile/'.$book->image)}}" alt="{{$book->title}}" class="card-img-top" style="width: 306px; height:200px;">
                        </a>
                        @else
                        <a href="{{route('detail',$book->id)}}">
                        <img src="https://placehold.co/900x1400" alt="{{$book->title}}" class="card-img-top" style="width: 306px; height:200px;">
                        </a>
                        @endif
                       
                        <div class="card-body">
                            <h3 class="h4 heading"><a href="#">{{$book->title}}</a></h3>
                            <p>{{$book->auther}}</p>
                            @php
                            if ($book->reviews_count > 0) {
                                $avgRating=$book->reviews_sum_rating/$book->reviews_count;
                            }else{
                                $avgRating=0;
                            }
                            $avgRatingper=($avgRating*100)/5;
                                
                            @endphp
                            <div class="star-rating d-inline-flex ml-2" title="">
                                <span class="rating-text theme-font theme-yellow">{{ number_format($avgRating,1)}}</span>
                                <div class="star-rating d-inline-flex mx-2" title="">
                                    <div class="back-stars ">
                                        <i class="fa fa-star " aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
    
                                        <div class="front-stars" style="width: {{$avgRatingper}}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="theme-font text-muted">({{$book->reviews_count > 0 ? $book->reviews_count.' Reviews' : '0 Reviews'}})</span>
                            </div>
                        </div>
                    </div>
                </div> 
                @endforeach
              
                @endif
               
          
            {{$books->links()}}  
                
            </div>
        </div>
    </div>
</div>   
 @endsection