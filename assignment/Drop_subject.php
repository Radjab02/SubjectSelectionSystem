<?php
session_start();
?>
<?php
      require 'start.php';
	    $ID=$_SESSION['student_id'] ;
      $student_name_query="SELECT Last_Name, First_Name FROM student where Stud_ID='$ID'";
      $student_name = $db->query($student_name_query);
      
      $myData ="SELECT Subject_ID,Title,Date,Time FROM subject WHERE Subject_ID IN (SELECT Subject_ID FROM enroll WHERE Status='Active' AND Stud_ID='$ID')";
       
      $users_t=$db->prepare($myData);
      $users_t->execute();

     $myData2 ="SELECT Subject_ID,Title,Date,Time FROM subject WHERE Subject_ID IN (SELECT Subject_ID FROM enroll WHERE Status='Active' AND Stud_ID='$ID')";
     $users2=$db->query($myData2);


       if(isset($_POST['submit1']))
   {		

	  	$sub_code2 ="SELECT Subject_ID FROM enroll where Stud_ID='$ID' AND Status ='Active'";
                $result2 = $db->prepare($sub_code2);
				$result2->execute();
                if(!($result2))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
				 
                }
				// check selected subjects
				$no1=$result2->rowCount();
		if($no1>2){
	  	$sub_code = $_POST["dropdown1"];
                
                $del_query="update enroll set Status ='Inactive' where Subject_ID='$sub_code' and Stud_ID ='$ID'"; 
			
               if(!($result = $db->query($del_query)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                }

         		 function page_redirect()
				 {
					$location="Drop_subject.php"; 
				   echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
				   exit; 
				 }
                 page_redirect();
			}		
							else
				  {
					 echo ' <script language="javascript"> ' ;
					 echo 'alert("You have reached the minimum number of subjects , \n you are not allowed to drop unless you add more subjects .")'; 
					 echo '</script>';
					  
				  }
           
	
   }

  ?>

<!DOCTYPE html>
<html>
  <head>
        <title> Drop Student Subject</title>
  <link rel="stylesheet" type="text/css" href="style1.css">	

  </head> 
        <body leftmargin="60px" topmargin="50px">
	   <br>
        <?php while ($s = $student_name->fetch()): ?>
        <?php  print htmlspecialchars($s['Last_Name']) ?>
		<?php  echo htmlspecialchars($s['First_Name']) ?>
 		<?php endwhile; ?>
 <div>                            
		 <ul style="float:right;list-style-type:none;">
			<li><a href="http://localhost/assignment/logout.php">Logout</a></li>
			</ul> <br><br>
		 <section id ="header">
                <span id="title">Subject Selection System</span>
                 &nbsp;   
				
                
		</section> 
		<section>
		<nav>
		<span>Navigation Menu</span>
			<ul>
			<li><a  href="student_list.php">Home</a></li>
			<li><a  href="Add_subject.php">Add</a></li>
			<li><a  href="Drop_subject.php">Drop</a>&nbsp;&nbsp;</p>
			</ul>
		</nav>		
		<br>
		</section>
		
       <section>
	   <table cellpadding="5" align="center">
		<caption><strong>Current Registered Subjects</strong></caption>
		
	      <tr>
		    <th>Subject_ID</th>
			<th>Title</th>			
			<th>Date</th>
			<th>Time</th>
			
		  </tr>
		   <?php while ($r = $users_t->fetch()):?>
		   <tr>
		      <td><?php echo htmlspecialchars($r['Subject_ID'])?></td>
			  <td><?php echo htmlspecialchars($r['Title'])?></td>
			  <td><?php echo htmlspecialchars($r['Date'])?></td>
			  <td><?php echo htmlspecialchars($r['Time'])?></td>
			  
		   </tr>
		   <?php endwhile; ?>
	    </table>
        </section>	

   <section class="space">		
             <br>
            <p ><strong> Remove subjects From the list:</strong></p>
	      <form action="" method="POST">
		    <select  name="dropdown1">
			  <option value="">Select subject(s)</option>
			   <?php foreach($users2->fetchAll() as $users3): ?>
	             <option value="<?php echo $users3['Subject_ID']?>"><?php echo $users3['Subject_ID'];?></option>
	           <?php endforeach;?>
			</select>
			 &nbsp;&nbsp;&nbsp;&nbsp;

			 <input type="submit" name="submit1" value="Drop" />
		  </form>
       </section>   
	   <section id="footer">
                    <span>  Copyright ©  Multimedia University</span>
		</section>
       </div>
	 </body>
</html>