

<div class="modal fade" id="AddPost">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
      <img class="ml-5"  src="{{url('images/loading.gif')}}"id='loader' style='width:150px;height:150px;display:none'>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		
    
		


        
			</div>
      

			<div class="modal-body">
      <h4 class="modal-title">Create Post </h4>
			<form action="{{url('/posts/store')}}" method="POST"role="form" class="form-horizontal" role="form" enctype="multipart/form-data" id="formAdd"> 
@csrf


      

        <div class="form-group">
            <legend>Title</legend>
            <input type="text" class="form-control" name="title" value="{{old('title')}}">
    
      <span class="text-danger" id="title">
        
          </span>
    
        </div>

        

        <div class="form-group">
            <legend>Description</legend>
            <textarea id="body" name="body" id="body" class="form-control" value="{{old('thumbnail')}}">
            {{old('body')}}
             </textarea>
            <span class="text-danger" id="body">
           
          </span>
     
        </div>


        <div class="form-group">
            <legend>Upload Photo</legend>
          <input type="file" class="form-control" name="thumbnail">
          <span class="text-danger" id="thumbnail">
         
          </span>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn" style="background-color:#2d5b85;color:white">Submit</button>
                <button type="submit" class="btn btn-secondary" onclick="reset()">Reset</button>
            </div>
        </div>
     
</form>
			</div>
		</div>
	</div>
</div>




