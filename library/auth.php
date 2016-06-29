<?php

/**
 * auth.php
 *
 * Authorization
 *
 * @author     Josip Hrnjak
 * @copyright  2016 Josip Hrnjak
 * @version    v0.03

 */

class userClass
{  


	public function userLogin($usernameEmail, $password){

		$db = getDB();
		$password_hash = sha1(AUTH_SALT.$password.AUTH_SALT);
		$stmt = $db->prepare(
			"SELECT uid FROM users
			WHERE 
			username = :username or email = :email
			AND 
			password = :password_hash");

		$stmt->bindParam("email", $email, PDO::PARAM_STR);
		$stmt->bindParam("password_hash", $password_hash, PDO::PARAM_STR);


		$stmt->execute();

		$count= $st->rowCount();
		$data= $stmt->fetch(PDO::FETCH_OBJ);
		$db= null;
		if($count)		{
			$_SESSION['uid']= $data->uid;
			return true;
		}// end if
		else{
			return false;
		} // end else

	} // end userLogin

	 // REGISTRACIJA KORISNIKA

	public function userRegistration($username, $password, $email, $first_name, $last_name){

		try{
			 $db = getDB();
			 $st= $db->prepare("
			 	SELECT uid FROM users
			 	WHERE
			 	username= :username or email=:email	");
			 $st -> bindParam("username", $username, PDO::PARAM_STR);
			 $st ->bindParam("email", $email, PDO::PARAM_STR);
			 $st-> execute();

			 $count=$st->rowCount();

			 if($count<1){
			 	$stmt = $db->prepare("
			 		INSERT INTO users(username, password,email,first_name,last_name)
			 		VALUES (:username, :email, :password_hash, :first_name, :last_name)");
			 	$stmt->bindParam("username", $username, PDO::PARAM_STR);
			 	$password_hash = sha1(AUTH_SALT.$password.AUTH_SALT);
			 	$stmt->bindParam("password_hash",$password_hash, PDO::PARAM_STR);
			 	$stmt->bindParam("email", $email, PDO::PARAM_STR);
			 	$stmt->bindParam("first_name", $first_name, PDO::PARAM_STR);
			 	$stmt->bindParam("last_name", $last_name, PDO::PARAM_STR);
			 	$stmt->execute();
			 	$uid=$db->lastInsertId();
			 	$db=null;
			 	$_SESSION["uid"]=$uid;
			 	return true;

			 } // end if
			 else{
			 	$db= null;
			 	return false;
			 }// end else


		} // end try
		catch(PDOException $e){
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 


		} // end catch

	} // end userRegistration

	public function userDetails($uid){

		try{

			$db = getDB();
			$stmt = $db->prepare("
				SELECT email, username, first_name, last_name 
				FROM
				users WHERE uid = :uid");
			$stmt->bindParam("uid", $uid, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_OBJ);
			return $data;
		}catch(PDOException $e){
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 

		}// end catch


	} //end userDetails

} // end userClass