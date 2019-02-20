<?php
session_start();

if(isset($_POST['submit'])){
	include 'dbconn.php';

	$uid=mysqli_real_escape_string($conn,$_POST['uname']);
	$pwd=mysqli_real_escape_string($conn,$_POST['pwd']);
	//error handling

	if(empty($uid)||empty($pwd)){
		header("Location: ../index.php?signin=emptyField");
		exit();

	}
	else{
		$sql="SELECT * FROM users where user_uid='$uid' OR user_email='$uid';";
		$result=mysqli_query($conn,$sql);
		$resultCheck=mysqli_num_rows($result);
		if($resultCheck<1){
			header("Location: ../index.php?login=error");
			exit();
		}
		else{
			if($row=mysqli_fetch_assoc($result)){
				//De-hashing the password
				$hashedPasswordCheck=password_verify($pwd,$row['user_pwd']);
				if($hashedPasswordCheck==false){
					header("Location: ../index.php?login=wrongPassword");
				}
				elseif($hashedPasswordCheck==true){
					//Login the user here
					$_SESSION['u_id']=$row['user_id'];
					$_SESSION['u_first']=$row['user_first'];
					$_SESSION['u_last']=$row['user_last'];
					$_SESSION['u_email']=$row['user_email'];
					$_SESSION['u_uid']=$row['uname'];
					header("Location: ../index.php?login=success");
					exit();

				}

			}
		}

	}

}
else{
	header("Location: ../index.php?login=error");
	exit();
}