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
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_user (name,username,password,UserTypeId,status) VALUES(:name,:username,:password,:UserTypeId,:status)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_user SET name = :name  , username = :username , password = :password , UserTypeId = :UserTypeId , status = :status  WHERE user_id = :user_id  ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->user_id = !isset($POST->user_id) ? 0 : $POST->user_id;
			$POST->status = !isset($POST->status) ? 0 : $POST->status;
			$POST->username = !isset($POST->username) ? 0 : $POST->username;
			$POST->password = !isset($POST->password) ? 0 : $POST->password;
			$POST->UserTypeId = !isset($POST->UserTypeId) ? 0 : $POST->UserTypeId;
			return $POST;
		}
		 function Save($POST){
			global $conn;

			if($POST->user_id == 0){
				$query = $this->Create();
			}else{
				$query = $this->Update();
				$query->bindParam(':user_id',$POST->user_id);

			}
			$query->bindParam(':name',$POST->name);
			$query->bindParam(':status',$POST->status);
			$query->bindParam(':username',$POST->username);
			$query->bindParam(':password',$POST->password);
			$query->bindParam(':UserTypeId',$POST->UserTypeId);
			$query->execute();	
		}
		

}



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


	
class UserRoleRepository{		
		public function RoleList(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_roles");
			$count = $query->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
		public function UserRoles($UserId){
			global $conn;
			$where = "";
			$where .= "And UserId = $UserId";
			$query = $conn->query("SELECT * FROM tbl_user_roles  
			LEFT JOIN tbl_roles  ON tbl_user_roles.RoleId = tbl_roles.Id
			WHERE 1 = 1  $where ");
			return $query->fetchAll(PDO::FETCH_OBJ);	
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
		public function DataList($UserId,$RoleId){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_roles WHERE UserId = '$UserId' AND  RoleId = '$RoleId'");
			return $query->fetch(PDO::FETCH_OBJ);
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_user_roles (UserId,RoleId,AllowView,AllowAdd,AllowEdit,AllowDelete) VALUES(:UserId,:RoleId,:AllowView,:AllowAdd,:AllowEdit,:AllowDelete)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_user_roles SET UserId = :UserId  , RoleId = :RoleId , AllowView = :AllowView , AllowAdd = :AllowAdd , AllowEdit = :AllowEdit , AllowDelete = :AllowDelete  WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->UserId = !isset($POST->UserId) ? 0 : $POST->UserId;
			$POST->RoleId = !isset($POST->RoleId) ? 0 : $POST->RoleId;
			$POST->AllowView = !isset($POST->AllowView) ? 0 : $POST->AllowView;
			$POST->AllowAdd = !isset($POST->AllowAdd) ? 0 : $POST->AllowAdd;
			$POST->AllowEdit = !isset($POST->AllowEdit) ? 0 : $POST->AllowEdit;
			$POST->AllowDelete = !isset($POST->AllowDelete) ? 0 : $POST->AllowDelete;
			return $POST;
		}
		 function Save($POST){
			global $conn;

			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->Update();
				$query->bindParam(':Id', $POST->Id);

			}
			$query->bindParam(':UserId',$POST->UserId);
			$query->bindParam(':RoleId',$POST->RoleId);
			$query->bindParam(':AllowView',$POST->AllowView);
			$query->bindParam(':AllowAdd',$POST->AllowAdd);
			$query->bindParam(':AllowEdit',$POST->AllowEdit);
			$query->bindParam(':AllowDelete',$POST->AllowDelete);
			$query->execute();	
		}
	
}		

?>