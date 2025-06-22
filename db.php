<?php
$host="localhost";
$user="root";
$password="";
$dbname="blogpost";

$conn=new mysqli($host,$user,$password,$dbname);
if($conn ->connect_error){
    die("connection failed:" .$conn ->connect_error);
}

// Table: comments
// Columns:
// id (int, primary, auto_increment)
// post_id (int, index)
// user_name (varchar(100))
// email (varchar(100))
// comment (text)
//
// This table is used for storing comments on posts.

?>