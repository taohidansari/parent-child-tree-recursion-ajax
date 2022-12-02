              <?php 
                include "dbconnection.php";
              ?>
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