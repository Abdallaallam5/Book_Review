@extends('layouts.app')
 @section('content')

 <div class="container mt-3 ">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <a href="index.html" class="text-decoration-none text-dark ">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
            </a>
            <div class="row mt-4">
                <div class="col-md-4">
                    @if (isset($book->image))
                        <img src="{{asset('uploads/profile/'.$book->image)}}" alt="{{$book->title}}" class="card-img-top" style="width: 306px; height:500px;">

                    @else
                    <img src="https://placehold.co/900x1400" alt="{{$book->title}}" class="card-img-top" style="width: 306px; height:200px;">

                    @endif
                </div>
                
                <div class="col-md-8">
                    @include('layouts.messages')
                    @php
                                    if ($book->reviews_count > 0) {
                                        $avgRating=$book->reviews_sum_rating/$book->reviews_count;
                                    }else{
                                        $avgRating=0;
                                    }
                                    $avgRatingper=($avgRating*100)/5;
                                        
                                    @endphp
                    <h3 class="h2 mb-3">{{$book->title}}</h3>
                    <div class="h4 text-muted">{{$book->auther}}</div>
                    <div class="star-rating d-inline-flex ml-2" title="">
                        <span class="rating-text theme-font theme-yellow">{{number_format($avgRating,1)}}</span>
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

                    <div class="content mt-3">
                        <p>
                            {{$book->description}}
                        </p>
                    </div>

                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h2 class="h3 mb-4">Readers also enjoyed</h2>
                        </div>
                        @if ($others->isNotEmpty())
                        @foreach ($others as $item)
                        <div class="col-md-4 col-lg-4 mb-4">
                            <div class="card border-0 shadow-lg">
<a href="{{route('detail',$item->id)}}">
                                @if (isset($item->image))
                        <img src="{{asset('uploads/profile/'.$item->image)}}" alt="{{$item->title}}" class="card-img-top" style="width: 270px; height:200px;">

                    @else
                    <img src="https://placehold.co/900x1400" alt="{{$item->title}}" class="card-img-top" style="width: 306px; height:200px;">

                    @endif
                </a>

                                <div class="card-body">
                                    @php
                                    if ($item->reviews_count > 0) {
                                        $avgRating=$item->reviews_sum_rating/$item->reviews_count;
                                    }else{
                                        $avgRating=0;
                                    }
                                    $avgRatingper=($avgRating*100)/5;
                                        
                                    @endphp
                                    <h3 class="h4 heading"><a href="{{route('detail',$item->id)}}">{{$item->title}}</a></h3>
                                    <p>{{$item->title}}</p>
                                    <div class="star-rating d-inline-flex ml-2" title="">
                                        <span class="rating-text theme-font theme-yellow">{{number_format($avgRating,1)}}</span>
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
                        

                                         
                    </div>
                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12  mt-4">
                            <div class="d-flex justify-content-between">
                                <h3>Reviews</h3>
                                <div>
                                    @if (Auth::check())
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Add Review
                                      </button>
                                    @else
                                        <a href="{{route('login')}}" class="btn btn-primary">Add Review</a>
                                    @endif
                                   
                                      
                                </div>
                            </div>                        
@if ($book->reviews)
@foreach ($book->reviews as $item)
<div class="card border-0 shadow-lg my-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="mb-3">{{$item->user->name}}</h4>
            <span class="text-muted">{{\carbon\carbon::parse($item->created_at)->format('d M, Y')}}</span>         
        </div>
       @php
           $ratingper=($item->rating/5)*100;
       @endphp
        <div class="mb-3">
            <div class="star-rating d-inline-flex" title="">
                <div class="star-rating d-inline-flex " title="">
                    <div class="back-stars ">
                        <i class="fa fa-star " aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                        <div class="front-stars" style="width: {{$ratingper}}%">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
                                               
        </div>
        <div class="content">
            <p>{{$item->review}}.</p>
        </div>
    </div>
</div>  
@endforeach  
@else
    <div>Reviews not found</div>
@endif
                           
                            
  
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>  
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="BookReviewForm" name="BookReviewForm">
                <input type="hidden" value="{{$book->id}}" name="book_id">
            <div class="modal-body">
                
                    <div class="mb-3">
                        <label for="" class="form-label">Review</label>
                        <textarea name="review" id="review" class="form-control" cols="5" rows="5" placeholder="Review"></textarea>
                    <p class="invalid-feedback" id="review-error"></p>
                    </div>
                    <div class="mb-3">
                        <label for=""  class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>   
 @endsection
@section('script')
<script>
$("#BookReviewForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:'{{route("savereview")}}',
        type:'POST',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:$("#BookReviewForm").serializeArray(),
        success:function(response){
            if(response.status==false){
                var errors=response.errors;
                if(errors.review){
                    $('#review').addClass('is-invalid');
                    $('#review-error').html(errors.review);

                }else{
                    $('#review').removeClass('is-invalid');
                    $('#review-error').html('');
                }


            }else{
                window.location.href = '{{ route("detail",$book->id) }}';
            }

        }
    })

})

</script>
 @endsection