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
	  $no1=$users_t->rowCount();
if($no1<1)$_SESSION['check_subject']="error";
				  
					 
					  
				 

  ?>

<!DOCTYPE html>
<html>
   <head>
        <title> Student Subjects</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
    </head> 
     <body leftmargin="60px" topmargin="50px">
	            <?php while ($s = $student_name->fetch()): ?>
                <?php  print htmlspecialchars($s['Last_Name']) ?>
		<?php  echo htmlspecialchars($s['First_Name']) ?>
 		<?php endwhile; ?>
           
		 <div>        
		 <ul style="float:right;list-style-type:none;">
			<li><a href="http://localhost/assignment/logout.php">Logout</a></li>
			</ul> <br><br>
		    
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
             <br>
         </section>
            <section id="footer">
                    <span>  Copyright ©  Multimedia University</span>
		</section>
      </div> 
			  
			  
			  <script language="javascript">  
			  var check = "OK"
			  
			  check="<?php if (isset($_SESSION['check_subject'])&&$_SESSION['check_subject']=="error") echo $_SESSION['check_subject'];?>"
			  if(check=="error"){
				  alert("you have not added any subject , \n please go to Add");
			
			  }
			  </script>
			
			
	 </body>
</html>