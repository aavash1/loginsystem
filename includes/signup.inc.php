<?php

if(isset($_POST['submit'])){
	include_once '../dbconn.php';

	$first=mysqli_real_escape_string($conn,$_POST['first']);
	$last=mysqli_real_escape_string($conn,$_POST['last']);
	$email=mysqli_real_escape_string($conn,$_POST['email']);
	$uid=mysqli_real_escape_string($conn,$_POST['uid']);
	$pwd=mysqli_real_escape_string($conn,$_POST['pwd']);

	if(empty($first)||empty($last)||empty($email)||empty($uid)||empty($pwd)){
		header("Location: ../signup.php?signup=empty");
		exit();
	}
	else{
		if(!preg_match("/^[a-zA-Z]*/$", $first)||!preg_match("/^[a-zA-Z]*/$", $last)){
			header("Location: ../signup.php?signup=invalid");
			exit();
		}
		else{
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=invalidEmail");
				exit();
			}
			else{
				$sql="SELECT * FROM users where user_uid='$uid';";
				$result=mysqli_query($conn,$sql);
				$resultCheck=mysqli_num_rows($resultCheck);
				if($resultCheck>0){
					header("Location: ../signup.php?signup=userExists");
					exit();
				}
				else{
					$hashedPassword = password_hash($pwd,PASSWORD_DEFAULT);
					$sql="INSERT INTO users(user_first,user_last,user_email,user_uid,user_pwd) VALUES ('$first','$last','$email','$uid','$hashedPassword');";
					mysqli_query($conn,$sql);
					header("Location: ../signup.php?signup=success");
				}
			}

		}

	}


}
else{
	header("Location: ../signup.php");
	exit();
}