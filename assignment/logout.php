<?php
session_start();
require 'start.php';
if(session_destroy()) // Destroying All Sessions
{
	
                $del_query="delete from mychart"; 
               if(!($result = $db->query($del_query)))
                {
	              print( "<p>Could not execute query!</p>" );
	             die( mysql_error());
                }
   header("Location: http://localhost/assignment/login.php"); // Redirecting To Home Page
}
?>