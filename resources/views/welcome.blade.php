@extends('../layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Laravel Ajax Crud</title>

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
   
   
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 

     
        <!-- Latest compiled and minified CSS -->


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
        .pb-4, .py-4 {
    
    background-color: #c3a9ff;
}

.page-item.active .page-link {
   
    background-color: #2d5b85;
    border-color: #c3a9ff;
}



</style>

    </head>
    <body>
   
           
      <div class="container" >
      <input type="text" placeholder="See title by typing..." id="search" class="w3-card form-control"><br> 
      </div>
      <div class="w3-display-container">       
            <div class="row" style="">
              

                <div class="col-md-12 col-md-offset-2">
                       
              <div id="posts">
               
              
              </div>
</div>

              <div id="modal">
              
              
              </div>
  

         

            </div>


        </div>

     
   
   <script>



$(function(){


    toastr.options = {
        "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"

}





    
$.get('{{url("posts")}}',function(data){

$("#posts").empty().append(data);

});



$("#posts").on('click',"#btnAdd",function(){
    
   
   
  
  $.get('{{url("posts/create")}}',function(data){


    $("#modal").empty().append(data);
    $("#AddPost").modal('show');


  })
   

});


$("#modal").on('submit',"#formAdd",function(e){

e.preventDefault();

//frmdata=$(this).serialize();
var frmdata=new FormData(this);
$.ajax({
        
        url:'{{url("posts/store")}}',
        type:'POST',
        data:frmdata,
        cache:false,
        contentType:false,
        processData:false,
        beforeSend: function(){
    
    $("#modal #loader").show();
   },
   complete:function(data){
    // Hide image container
    $("#loader").hide();
   },
  
        
}).done(function(data){//data of index page which was redirected

     $("#modal #resultStatus").empty();
     $("#modal #title").empty();
     $("#modal #body").empty();
     $("#modal #thumbnail").empty();
     $("#AddPost").modal('hide');
     Command: toastr["success"]("Data Added Successfully")

     $("#posts").empty().append(data);
      

       })
       .fail(function(error){

      error=error.responseJSON;

      if(error.errors.title!=null){
      error.errors.title.forEach(function(element,index){

        $("#modal #title").empty().append('<div class="alert alert-danger">'+element+'</div>');

      })
      }
      else{
        $("#modal #title").empty();
      }

      if(error.errors.body!=null){
      error.errors.body.forEach(function(element,index){

$("#modal #body").empty().append('<div class="alert alert-danger">'+element+'</div>');

})}
else{
    $("#modal #body").empty();
}

if(error.errors.thumbnail!=null){
error.errors.thumbnail.forEach(function(element,index){

$("#modal #thumbnail").empty().append('<div class="alert alert-danger">'+element+'</div>');

})}
else{
    $("#modal #thumbnail").empty();
}



       })

});



$("#posts").on('click','.btnManage',function(){
 
    id=$(this).data('task');

$.get('{{url("posts/edit")}}/'+id,function(data){


    $("#modal").empty();//phly agr koe modal ha tu remove agr add wala para ha tu
    $("#modal").append(data);//edit wala modal agia
    $("#EditPost").modal('show');//jo model aya show kro is id sy
})
})

$("#modal").on('submit','#EditForm',function(e){

e.preventDefault();

var frmdata=new FormData(this);
$.ajax({
        
        url:'{{url("posts/update")}}',
        type:'POST',
        data:frmdata,
        cache:false,
        contentType:false,
        processData:false,
        beforeSend: function(){
    
    $("#modal #loader").show();
   },
   complete:function(data){
    // Hide image container
    $("#loader").hide();
   },
   
             })
       .done(function(data){//data of index page which was redirected
        

     $("#modal #resultStatus").empty();
     $("#modal #title").empty();
     $("#modal #body").empty();
   


     $("#posts").empty().append(data);
     $("#EditPost").modal('hide');
     Command: toastr["success"]("Data Updated Successfully")

       })
       .fail(function(error){

      error=error.responseJSON;

      if(error.errors.title!=null){
      error.errors.title.forEach(function(element,index){

        $("#modal #title").empty().append('<div class="alert alert-danger">'+element+'</div>');

      })
      }
      else{
        $("#modal #title").empty();
      }

      if(error.errors.body!=null){
      error.errors.body.forEach(function(element,index){

$("#modal #body").empty().append('<div class="alert alert-danger">'+element+'</div>');

})}
else{
    $("#modal #body").empty();
}





       })



});




$("#modal").on('click','#btnDelete',function(){

id=$(this).data('task');

$.get('{{url("posts/destroy")}}/'+id,function(data){

    $("#posts").empty().append(data);
    $("#EditPost").modal('hide');
    Command: toastr["error"]("Data Deleted");
});

});


$("#posts").on('click','.pagination a',function(e){
            
            url=$(this).attr('href');
           

     e.preventDefault();

     

     $.get(url,function(data){

         $("#posts").empty().append(data);

     })

         });

         }); 

  
   </script>

<script>
  $( function() {
   
    $( "#search" ).autocomplete({
      source: "{{url('posts/search')}}"
    });
  } );
  </script>









        <!-- jQuery -->
       
        <!-- Bootstrap JavaScript -->
      
<!-- jQuery library -->


<!-- Popper JS -->
  <script  src="{{url('js/jquery.bighover.js')}}"></script>
 
       <script type="text/javascript">
$(document).ready(function(){
    //chaging position, possible values are : 'right', 'top-right', 'top', 'top-left', 'left', 'bottom-left', 'bottom', and 'bottom-right' (default to 'bottom-right')
    $('#posts').hover(function(){
  
   $("#posts img").bighover({

  height: '250',
  width:'250',
      position: 'bottom'

   });

    });

    
});
</script>

    </body>
</html>
@endsection
