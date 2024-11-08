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
                    My Reviews
                </div>
                <div class="card-body pb-0">      
                    <div class="d-flex justify-content-end">
                        
                        <form action="" method="GET">
                        <div class="d-flex">
                            <input type="text" calss="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="keyword">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <a href="{{route('reviews')}}" class="btn btn-secondary ms-2">Clear</a>
                        </div>
                    </form>
                        </div>       
                    <table class="table  table-striped mt-">
                        <thead class="table-dark">
                            <tr>
                                <th>Book</th>
                                <th>Review</th>
                                <th>Rating</th>                                 
                                <th>Status</th>                                  
                                <th width="100">Action</th>
                            </tr>
                            <tbody>
                                @if ($reviews->isNotEmpty())
                                @foreach ($reviews as $review)
                                    
                                @endforeach
                                <tr>
                                    <td>{{$review->book->title}}</td>
                                    <td>{{$review->review}}</td>                                        
                                    <td>{{$review->rating}}</td>
                                    <td>
                                    @if ($review->status == 1)
                                        <span class="text-success">Active</span>
                                    @else
                                    <span class="text-danger">Block</span>
                                    @endif
                                    </td>
                                    <td>
                                        <a href="{{route('edit.my_review',$review->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" onclick="deletereview({{$review->id}});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endif
                              
                                  
                            </tbody>
                        </thead>
                    </table>   
                {{$reviews->links()}}
                </div>
                
            </div>                
        </div>
    </div>       
</div>                
 
@endsection
@section('script')
<script>
    function deletereview(id){
if(confirm('Are you sure deleted review?')){
    $.ajax({
        url:'{{route("deleted.my.review")}}',
        data:{id:id},
        type:'post',
        headers: {                         
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response){
            window.location.href = '{{ route("reviews") }}'; 
        },
    })
}

    }
</script>
    
@endsection