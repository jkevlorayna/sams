<?php 
class LoginRepository{
		public function changePassword(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$id = (!isset($POST->user_id)) ? 0 : $POST->user_id;
			$cpassword =  $POST->cpassword;
			$newpassword =  $POST->newpassword;
			
			$count = $conn->query("SELECT * FROM tbl_user WHERE  password = '$cpassword' AND user_id = '$id' ")->rowcount();

			if($count > 0){
				$query = $conn->prepare("UPDATE tbl_user SET password = ? WHERE user_id = ? ");
				$query->execute(array($newpassword,$id));
			}else{
				 return 'cpFalse';
			}

			
		}
		public function loginMember(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$username =  $POST->username;
			$password =  $POST->password;
		
			$query = $conn->prepare("SELECT * FROM tbl_member WHERE username =  ?  AND password = ? ");
			$query->execute(array($username,$password));

			
			$count = $query->rowcount();
				
			if($count > 0){
					session_start();
					
					$row = $query->fetch(PDO::FETCH_ASSOC);
					$userData = array(
					"Id" => $row['Id'] ,
					"firstname" => $row['firstname'],
					"lastname" => $row['lastname']
					);
					$_SESSION['Id'] = $row['Id'];
					$_SESSION['isAuthenticated'] = "true";
					$data['granted'] = "true";
					$data['Results'] = $userData;
					
					return $data;	
			}else{
					$data['granted'] = "false";
					$data['Results'] = '';
					return $data;	
			}
		}
				public function login(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$id = (!isset($POST->user_id)) ? 0 : $POST->user_id;
			$username =  $POST->username;
			$password =  $POST->password;
		
			$query = $conn->prepare("SELECT * FROM tbl_user WHERE username =  ?  AND password = ? ");
			$query->execute(array($username,$password));

			
			$count = $query->rowcount();
				
			if($count > 0){
					session_start();
					
					$row = $query->fetch(PDO::FETCH_ASSOC);
					$userData = array("user_id" => $row['user_id'] , "name" => $row['name']);
					$_SESSION['isAuthenticated'] = "true";
					$data['granted'] = "true";
					$data['Results'] = $userData;
					
					return $data;	
			}else{
					$data['granted'] = "false";
					$data['Results'] = '';
					return $data;	
			}
		}
		public function logout(){
			session_start();
			session_destroy();
		}
		public function auth(){
			session_start();
			 if(!isset($_SESSION['isAuthenticated'])){
				return "false";
			}else{
				return "true";
			}
		}
		public function authUser(){
			session_start();
			 if(!isset($_SESSION['isAuthenticated'])){
				return "false";
			}else{
				return "true";
			}
		}
}
$GLOBALS['LoginRepo'] = new LoginRepository();		
?>