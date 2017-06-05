
<?php
  
   require 'start.php';
  
   //construct query

   
   
$userQuery="SELECT Subject_ID,Title,Batch_No, Date,Time from subject where Year in (select  Stud_yr FROM student where Stud_id='AB01')";   
$users = $db->query($userQuery);
$myData ="SELECT Subject_ID,Title,Batch_No, Date,Time from subject where Year in (select  Stud_yr FROM student where Stud_id='AB01')";
   $users_t=$db->prepare($myData);
   $users_t->execute();

   $student_name_query="SELECT Last_Name, First_Name FROM student where Stud_ID='AB01'";
   $student_name = $db->query($student_name_query);

   $myData1 ="SELECT Subject_ID,Title,Time FROM mycart";
   $users1=$db->query($myData1);
   $myData2 ="SELECT Subject_ID,Title,Time FROM mycart";
   $users2=$db->query($myData2);

   

   if(isset($_POST['submit']))
   {
	  	$sub_code = $_POST["dropdown"];
                $query = "INSERT INTO mycart SELECT Subject_ID,Title,Time FROM subject WHERE Subject_ID ='$sub_code'";
 
               if(!($result = $db->query($query)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                } 
   }

    if(isset($_POST['submit1']))
   {
	  	$sub_code = $_POST["dropdown1"];
                $del_query="delete from mycart where  Subject_ID ='$sub_code'"; 
               if(!($result = $db->query($del_query)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                } 
   }
   
      if(isset($_POST['confirm']))
   {
	  	$sub_code ="SELECT Subject_ID FROM mycart";
                $result = $db->query($sub_code);
                if(!($result))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                }
           
           while ($r = $result->fetch()):
           
           $temp = htmlspecialchars($r['Subject_ID']); 
           //print( $temp );

           $myData3 ="update enroll set Status ='Active' where Subject_ID='$temp' and Stud_ID ='AB01'";
           if(!($results = $db->query($myData3)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                } 
         
           endwhile; 
   }

   
?>

<!DOCTYPE html>
<html>
  <head>
        <title>Add Subject</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
  <style>
  .title{
          text-decoration:none;
          font-size:50px;  
       }	 
   </style>
  </head> 
     <body leftmargin="60px" topmargin="50px">
	   <br>
	   
   
            <?php while ($s = $student_name->fetch()): ?>
                <?php  print htmlspecialchars($s['Last_Name']) ?>
		<?php  echo htmlspecialchars($s['First_Name']) ?>
 		<?php endwhile; ?>
		<div>   
			<ul style="float:right;list-style-type:none;">
			<li><a href="http://localhost/myphp/final_version/logout.php">Logout</a></li>
			</ul>
			<br>
           <br>
           
		  
            <section id="header">
                <span id="title">Subject Selection System</span>
                 &nbsp;   
				<!--  <a class="anc" href="student_list.php">Home</a>&nbsp;&nbsp; 
                <a  class="anc" href="Add_subject.php">Add</a>&nbsp;&nbsp; -->
                
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
          <td> <p class="space"><strong> Remove subjects From the cart:</strong></p>
	      <form action="" method="POST">
		    <select class="space" name="dropdown1">
			  <option value="">Select subject(s)</option>
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
                    <span>  Copyright © Multemedia University</span>
		</section>
	 </body>
</html>