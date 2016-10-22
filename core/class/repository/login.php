<?php 
class LoginRepository{
		public function changePassword($POST){
			global $conn;


			$query = $conn->prepare("SELECT * FROM tbl_user WHERE  password = :password AND user_id = :user_id ");
			$query->bindParam(':password', $POST->cpassword);
			$query->bindParam(':user_id', $POST->user_id);
			$query->execute();
			
			$count = $query->rowcount();
			
			if($count > 0){
				$query = $conn->prepare("UPDATE tbl_user SET password = :password WHERE user_id = :user_id ");
				$query->bindParam(':password', $POST->newpassword);
				$query->bindParam(':user_id', $POST->user_id);
				$query->execute();
			}else{
				 return 'cpFalse';
			}

			
		}
		public function loginMember($POST){
			global $conn;
			
			$query = $conn->prepare("SELECT * FROM tbl_member WHERE username =  :username  AND password = :password ");
			$query->bindParam(':username', $POST->username);
			$query->bindParam(':password', $POST->password);
			$query->execute();

			
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
		public function Transform($POST){
			$POST->user_id = (!isset($POST->user_id)) ? 0 : $POST->user_id;
			$POST->username = (!isset($POST->username)) ? '' : $POST->username;
			$POST->password = (!isset($POST->password)) ? '' : $POST->password;	
			$POST->cpassword = (!isset($POST->cpassword)) ? '' : $POST->cpassword;	
			$POST->newpassword = (!isset($POST->newpassword)) ? '' : $POST->newpassword;	
			return $POST;	
		}
		public function login($POST){
			global $conn;

		
			$query = $conn->prepare("SELECT * FROM tbl_user WHERE username =  :username  AND password = :password ");
			$query->bindParam(':username', $POST->username);
			$query->bindParam(':password', $POST->password);
			$query->execute();

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

?>