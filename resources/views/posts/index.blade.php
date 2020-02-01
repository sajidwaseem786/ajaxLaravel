

<div class="container"style="background-color:white;">
<h3 class="display-3">Login To Add Post</h3>


<button id="btnAdd" class="btn " style="float:right;background-color:#2d5b85;color:white">Add new Post</button><br><br>



@if($msgClass=session('msgClass'))

@if($message=session('message'))
<div class="alert {{$msgClass}}">
{{$message}}

</div>
@endif

@endif
<table class="table table-hover">
    <thead style="color:#2d5b85">
        <tr>
            <th>Sr#</th>
            <th>Title</th>
            <th>Body</th>
            <th>Image</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
        <tr>
            <td>{{++$i}}</td>
            <td>{{$post->title}}<br>
           <i class="text-muted"> {{$post->user['name']}} {{$post->created_at->diffForHumans()}}</i></td>
            <td>{!! $post->body !!}</td>
         
         
        
        
        
            <td><img id="bh-1"class="bh-image w3-card"style="width:150px;height: 150px" src="{{url('images/'.$post->image)}}"></td>
            <td>
            @if(auth::check() && auth::user()->id===$post->user_id)
  
              <!-- <a href="{{url('posts/edit',$post->id)}}" class="btn btn-primary">Edit</a>
              <a href="{{url('posts/show',$post->id)}}" class="btn btn-secondary">Details</a>
              <a href="{{url('posts/destroy',$post->id)}}" class="btn btn-danger" value="delete"> Delete</a> -->

              <span class="pull-right"><button type="button" class="btn btn-success btn-xs btnManage"style="background-color:#2d5b85;color:white" data-task="{{$post->id}}"><i class="fa fa-cog w3-spin"></i></button></span>
              
            @endif  
            </td>

         </tr>
      
        @endforeach
    </tbody>
</table>
<div class=" container" style="background-color:white">{!!$posts->links()!!}</div><br><br>
</div>



