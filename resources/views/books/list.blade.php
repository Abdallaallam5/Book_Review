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
                    Books
                </div>
                <div class="card-body pb-0">            
                    <div class="d-flex justify-content-between">
                        <a href="{{route('add.book')}}" class="btn btn-primary">Add Book</a> 
                        <form action="" method="GET">
                        <div class="d-flex">
                            <input type="text" calss="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="keyword">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <a href="{{route('books')}}" class="btn btn-secondary ms-2">Clear</a>
                        </div>
                    </form>
                        </div>         
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                            <tbody>
                                @if ($books->isNotEmpty())
                                @foreach ($books as $book)
                                @php
                            if ($book->reviews_count > 0) {
                                $avgRating=$book->reviews_sum_rating/$book->reviews_count;
                            }else{
                                $avgRating=0;
                            }
                            $avgRatingper=($avgRating*100)/5;
                                
                            @endphp
                                <tr>
                                    <td>{{$book->title}}</td>
                                    <td>{{$book->auther}}</td>
                                    <td>{{number_format($avgRating,1)}} ({{$book->reviews_count > 0 ? $book->reviews_count.' Reviews' : '0 Reviews'}})</td>
                                    <td>
                                        @if ($book->status == 1)
                                        <span class="text-success">Active</span>
                                    @else
                                    <span class="text-danger">Block</span>
                                        
                                    @endif
                                </td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                        <a href="{{route('edit.book',$book->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" onclick="deletebook({{ $book->id }});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                    
                                @endforeach

                                @else
                                    <tr>
                                        <td colspan="5">Books not found</td>
                                    </tr>
                                @endif

                            </tbody>
                        </thead>
                    </table>   
                     @if ($books->isNotEmpty())
                    {{$books->links()}}
                  @endif
                </div>
                
            </div>                
        </div>
    </div>       
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 function deletebook(id){
    if (confirm("are you sure to deleted book?")) {
    $.ajax({
        url: '{{ route("delete.book") }}', 
        type: 'DELETE',                    
        data: { id: id },                  
        headers: {                         
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
                 
            window.location.href = '{{ route("books") }}'; 
        },
        error: function(xhr) {
            alert("canot deletd book"); 
            console.error(xhr.responseText);
        }
    });
}

    }


    
    </script>    
@endsection