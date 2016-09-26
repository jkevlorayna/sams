<?php 
class UserRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user  WHERE user_id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		 public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user WHERE user_id = '$id'");
			$query->execute();	
		}
		 public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT * FROM  tbl_user 
			LEFT JOIN tbl_user_type ON tbl_user.UserTypeId =  tbl_user_type.Id
			WHERE name LIKE '%$searchText%' AND UserTypeId != 0 LIMIT $pageNo,$pageSize  ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_user")->rowcount() ;
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		 public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
		
			$id  = (!isset($POST->user_id))? 0 : $POST->user_id;
			$name = $POST->name;
			$status = $POST->status;
			$username = $POST->username;
			$password = $POST->password;
			$UserTypeId = $POST->UserTypeId;

			
			if($id == 0){
				$query = $conn->prepare("INSERT INTO tbl_user (name,username,password,UserTypeId,status) VALUES(?,?,?,?,?)");
				$query->execute(array($name,$username,$password,$UserTypeId,$status));	
			}else{
				$query = $conn->prepare("UPDATE tbl_user SET name = ?  , username = ? , password = ? , UserTypeId = ? , status = ?  WHERE user_id = ? ");
				$query->execute(array($name,$username,$password,$UserTypeId,$status,$id));	
			}
		}
}
$GLOBALS['UserRepo'] = new UserRepository();


class UserTypeRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_type  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user_type  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize ){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			$query = $conn->query("SELECT * FROM  tbl_user_type  LIMIT $pageNo,$pageSize  ");
			if($searchText != ''){
				$count = $query->rowcount();
			}else{
				$count = $conn->query("SELECT * FROM  tbl_user_type")->rowcount();
			}
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
	
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$user_type =  $POST->user_type;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_user_type (user_type) VALUES(?)");
				$query->execute(array($user_type));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_user_type SET user_type = ?   WHERE Id = ? ");
				$query->execute(array($user_type,$id));	
			}
		}
}
$GLOBALS['UserTypeRepo'] = new UserTypeRepository();

	
class UserRoleRepository{		
		public function RoleList(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_roles");
			$count = $query->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_roles  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user_roles  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList(){
			global $conn;
			$UserId = $_GET['UserId'];
			$query = $conn->query("SELECT tbl_user_roles.RoleId As Id,tbl_roles.role FROM  tbl_user_roles
			LEFT JOIN tbl_roles ON tbl_user_roles.RoleId = tbl_roles.Id
			WHERE UserId = '$UserId'
			");
			$count = $query->rowcount();

			$query1 = $conn->query("SELECT * FROM  tbl_roles");
			
			$data = array();
			$data['Roles'] = $query1->fetchAll(PDO::FETCH_ASSOC);
			$data['UserRole'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			
			$UserId = $_GET['UserId'];
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$query = $conn->prepare("DELETE FROM tbl_user_roles WHERE UserId = ?");
			$query->execute(array($UserId));
			
			foreach($POST as $row){	
				$query = $conn->prepare("INSERT INTO tbl_user_roles (UserId,RoleId) VALUES(?,?)");
				$query->execute(array($UserId,$row->Id));
			}
		}
}		
$GLOBALS['UserRoleRepo'] = new UserRoleRepository();	
?>