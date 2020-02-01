

       




<div class="modal fade" id="EditPost">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
  

      <img class="ml-5"  src="{{url('images/loading.gif')}}"id='loader' style='width:150px;height:150px;display:none'>

      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		
    
		


        
			</div>
      

			<div class="modal-body">
      <h4 class="modal-title">Edit Post </h4>
			<form action="{{url('/posts/update')}}" method="POST"role="form" class="form-horizontal" role="form"id="EditForm"> 
@csrf

<input type="hidden" name="id" value={{$editAblePost->id}}>
 

        <div class="form-group">
            <legend>Title</legend>
            <input type="text" class="form-control" name="title" value="{{$editAblePost->title}}">
    
      <span class="text-danger" id="title">
        
          </span>
    
        </div>

        

        <div class="form-group">
            <legend>Description</legend>
            <textarea  name="body" class="form-control" >
            {{$body=$editAblePost->body}}
           
             </textarea>
            <span class="text-danger" id="body">
           
          </span>
     
        </div>
        <div class="modal-footer">
        <button type="submit"id="id" class="btn"style="background-color:#2d5b85;color:white">Save Changes</button>
       
        </form> 

        
				<button type="button" data-task="{{$editAblePost->id}}" class="btn btn-danger"id="btnDelete">delete</button>
			
			</div>
     


              
			</div>
		</div>
	</div>
</div>




