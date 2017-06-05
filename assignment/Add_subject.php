<?php
session_start();
?>

<?php
  
   require 'start.php';
  
 
  $ID=$_SESSION['student_id'] ;
   
$userQuery="SELECT subject.Subject_ID FROM subject LEFT JOIN mychart ON (subject.Subject_ID = mychart.Subject_ID)WHERE mychart.Subject_ID IS NULL AND Year in (select Stud_yr FROM student where Stud_ID='$ID') AND subject.Subject_ID IN(SELECT Subject_ID FROM enroll WHERE enroll.Status='Inactive')";   
$users = $db->query($userQuery);
$myData ="SELECT Subject_ID,Title,Batch_No, Date,Time from subject where Year in (select  Stud_yr FROM student where Stud_ID='$ID')";
   $users_t=$db->prepare($myData);
   $users_t->execute();

   $student_name_query="SELECT Last_Name, First_Name FROM student where Stud_ID='$ID'";
   $student_name = $db->query($student_name_query);

   $mycartData ="SELECT Subject_ID,Title,Time FROM mychart";
   $cartData=$db->prepare($mycartData);
   
   $myData2 ="SELECT Subject_ID,Title,Time FROM mychart";
   //$cartDrop_down=$db->query($myData2);
   $cartDrop_down=$db->prepare($myData2);
  
  //confirm query
  $confirm_query="SELECT COUNT (DISTINCT Subject_ID) from mychart";
  $confirm_rows=$db->prepare($confirm_query);
  $confirm_rows->execute();
  
   

   if(isset($_POST['submit']))
   {
	  	      $sub_code = $_POST["dropdown"];
              $query = "INSERT INTO mychart SELECT Subject_ID,Title,Time FROM subject WHERE Subject_ID ='$sub_code'";
 
               if(!($result = $db->query($query)))
                {
	              print( "<p>Could not execute query1!</p>" );
	             die( mysql_error());
                } 
				function page_redirect()
				 {
					$location="Add_subject.php"; 
				   echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
				   exit; 
				 }
                 page_redirect();		
   }

    if(isset($_POST['submit1']))
   {
	  	$sub_code = $_POST["dropdown1"];
                $del_query="delete from mychart where  Subject_ID ='$sub_code'"; 
               if(!($result = $db->query($del_query)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                }
             function page_redirect()
				 {
					$location="Add_subject.php"; 
				   echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
				   exit; 
				 }
                 page_redirect();   				
   }

   
   if(isset($_POST['confirm']))
   {
	  	$sub_code ="SELECT Subject_ID FROM mychart";
                $result = $db->prepare($sub_code);
				$result->execute();
                if(!($result))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
				 
                }
				// check selected subjects
				$no1=$result->rowCount();
				
	  	$sub_code2 ="SELECT Subject_ID FROM enroll where Stud_ID ='$ID' AND Status ='Active'";
                $result2 = $db->prepare($sub_code2);
				$result2->execute();
                if(!($result2))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
				 
                }
				// check selected subjects
				$no2=$result2->rowCount();
				$no=$no1+$no2;
				if($no >=2 && $no <=5)
				{
					while ($r = $result->fetch()):
					   
					   $temp = htmlspecialchars($r['Subject_ID']); 
					   //print( $temp );

					   $myData3 ="update enroll set Status ='Active' where Subject_ID='$temp' and Stud_ID ='$ID'";
					   if(!($results = $db->query($myData3)))
							{
							  print( "<p>Could not execute query!</p>" );
							 die( mysql_error());
							} 
					 
                    endwhile;
					
						  	$sub_code3 ="DELETE FROM mychart WHERE 1";
							$result3 = $db->prepare($sub_code3);
							$result3->execute();
							$_SESSION['check_subject']="OK";
					header('Location: student_list.php');
				}
				else
				  {
					 echo ' <script language="javascript"> ' ;
					 echo 'alert("You can only select minimum of 2 and maximum of 5 subjects")'; 
					 echo '</script>';
					  
				  }
           
            
   }
  
  
?>

<!DOCTYPE html>
<html>
  <head>
        <title>Add Subject</title>
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
			</ul>
			<br>
           <br>
		   
		         <section id="header">
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
		<caption><strong>Subject List</strong></caption>
	      <tr>
		    <th>Subject_ID</th>
			<th>Title</th>
			<th>Batch_No</th>
			<th>Date</th>
			<th>Time</th>
			
		  </tr>
		   <?php while ($r = $users_t->fetch()):?>
		   <tr>
		      <td><?php echo htmlspecialchars($r['Subject_ID'])?></td>
			  <td><?php echo htmlspecialchars($r['Title'])?></td>
			  <td><?php echo htmlspecialchars($r['Batch_No'])?></td>
			  <td><?php echo htmlspecialchars($r['Date'])?></td>
			  <td><?php echo htmlspecialchars($r['Time'])?></td>
			  
		   </tr>
		   <?php endwhile; ?>
	    </table>  
            <br>
		 </section>
		 
         <section>
		 
		<table> <tr>
   <td>
		 
	<form action="" method="POST">
	<table cellpadding="5" class="cart">
	<caption><strong>My Cart</strong></caption>
	<tr>
						
			<th>Subject ID</th>
                        <th>Title</th>
                        <th>Time </th>
    </tr>
           <?php $cartData->execute();  while ($r = $cartData->fetch()):?>
		   <tr>
		      <td><?php echo htmlspecialchars($r['Subject_ID'])?></td>
			  <td><?php echo htmlspecialchars($r['Title'])?></td>			  
			  <td><?php echo htmlspecialchars($r['Time'])?></td>			  
		   </tr>
		   <?php endwhile; ?>
       
                  <tr>  <td></td><td></td><td><input type="submit" name="confirm" value="Confirm" /></td> </tr>
      </table> 
	  
   </form>
		  </td>


</tr>
	</table>	 
<table> 
  <tr>	
    <td>	 
 		  <strong>Add subjects to the cart:</strong><p>
		  <form action="" method="POST">
		    <select class=""  name="dropdown">
			  <option value="">Select subject(s)</option>
			   <?php foreach($users->fetchAll() as $user): ?>
	             <option value="<?php echo $user['Subject_ID']?>"><?php echo $user['Subject_ID'];?></option>
	           <?php endforeach;?>
			</select>
			 &nbsp;&nbsp;&nbsp;&nbsp;
			 <input type="submit" name="submit" value="Add" />
		  </form>
	      </td>
          <td> <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remove subjects From the cart:</strong><p>
	      <form action="" method="POST">
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select class="" name="dropdown1">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<option value="">Select subject(s)</option>
			   <?php $cartDrop_down->execute(); foreach($cartDrop_down->fetchAll() as $users3): ?>
	             <option value="<?php echo $users3['Subject_ID']?>"><?php echo $users3['Subject_ID'];?></option>
	           <?php endforeach;?>
			</select>
			 &nbsp;&nbsp;&nbsp;&nbsp;
			 <input type="submit" name="submit1" value="Remove" />
		  </form>
		  </td>
		  
		  </tr>
		  
 </table>		  
 </section>		 		 
    
     </div>	
	 <section id="footer">
                    <span>  Copyright © Multimedia University</span>
		</section>
 
	 </body>
</html>