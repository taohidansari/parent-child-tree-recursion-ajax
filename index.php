
<?php
  include "dbconnection.php"; 
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Hello, world!</title>
  </head>
  <body>
    



    <div id="members">
  
    	<?php
   // taking all data in multidim array
    	$datas = [];
    	$sql_m = "SELECT *FROM members";
    	$rows_m = mysqli_query($connection,$sql_m);
      while(  $res_m = mysqli_fetch_assoc($rows_m) ){
         $datas[] =  $res_m;
      }

  /// recursion function
      function generatePageTree($datas, $parent = 0, $limit=0){
  	if($limit > 1000) return ''; // Make sure not to have an endless recursion
  	$tree = '<ul>';
  	for($i=0, $ni=count($datas); $i < $ni; $i++){
  		if($datas[$i]['parent_id'] == $parent){
  			$tree .= '<li>';
  			$tree .= $datas[$i]['name'];
  			$tree .= generatePageTree($datas, $datas[$i]['id'], $limit++);
  			$tree .= '</li>';
  		}
  	}
  	$tree .= '</ul>';
  	return $tree;
  }
  echo(generatePageTree($datas));
    	?>

    </div>


  






  <br><br><br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Add Member
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
             <b>Select Parent</b>
             <select id="parent_id" class="form-control">
             	 <option value="0">No Parent</option>
             	 <?php
             	  $sql5 = "SELECT *FROM parents"; 
                  $rows_5  = mysqli_query($connection,$sql5); 	
             	  while ( $res5 = mysqli_fetch_assoc($rows_5) ) {
             	  	   ?>
             	  	    <option value="<?php echo $res5["id"]; ?>"><?php echo $res5["parent_name"]; ?></option>
             	  	   <?php 
             	  }
             	 ?>
             </select>
            <br>
            <b>Name</b>
            <input type="text" id="child_name" class="form-control" />
            <br>
            <button id="save" class="btn btn-success">Save</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>





   <script type="text/javascript">
   	  $(document).ready(function(){

 
     	/* $.post('update-parent.php', {}, function(data){
     	     $("#parent_id").html(data);
     	 });*/


        $("#save").click(function(){
           var parent_id =  $("#parent_id").val();
           var child_name =  $("#child_name").val();
            if( child_name != "" && child_name != " " ){
                

               //empty name 
                $("#child_name").val("");

           
                 // ajax 
                  $.post('save_name.php', { parent_id:parent_id, child_name:child_name }, function(data){
                          
                  

                   // append if no parent
                     if( parent_id == 0 ){
                       $('ul:first').append("<li>"+child_name+"</li>");
                     }else{
                         var parent_name = data;
                         parent_name = parent_name.trim();
                         // perform append here
                     }

                           // update parent list
                            $.post('update-parent.php', {}, function(data){
                          	     $("#parent_id").html(data);
                          	 });

                            // update node
                            $.post('update-node.php', {}, function(data){
                          	     $("#members").html(data);
                          	 });


                  } );

                 


            }else{
            	alert("Please enter name");
            	$("#child_name").focus();
            }
        });

   	  });
   </script>




  </body>
</html>