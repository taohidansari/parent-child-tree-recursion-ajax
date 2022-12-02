<?php 
  
   include "dbconnection.php";
   $parent_id =   $_POST["parent_id"] ;
   $child_name  =   $_POST["child_name"];


   // save as parent
   $sql1 =  "INSERT INTO parents SET parent_name = '$child_name'";
   mysqli_query($connection, $sql1);


   /// save as child
     $sql5 = "INSERT INTO members SET parent_id = $parent_id, name = '$child_name', created_date = NOW()  ";
   mysqli_query($connection, $sql5);

   
   // get parent name
   if( $parent_id != 0 ){
     $sql44 = "SELECT parent_name FROM parents WHERE id = $parent_id";
     $rows44 = mysqli_query($connection,$sql44);
      $res44 = mysqli_fetch_assoc($rows44);
     echo $parent_name = $res44["parent_name"];
   }


?>