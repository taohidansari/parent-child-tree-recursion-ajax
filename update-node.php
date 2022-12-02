
    	<?php
      include "dbconnection.php";
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
