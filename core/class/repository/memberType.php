<?php 
class MemberTypeRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_type  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member_type  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_member_type WHERE type LIKE '%$searchText%' $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_member_type")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_member_type (type,EnableAdd,EnableBarcode) VALUES(:type,:EnableAdd,:EnableBarcode)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_member_type SET type = :type  , EnableAdd = :EnableAdd , EnableBarcode = :EnableBarcode WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->type = !isset($POST->type) ? '' : $POST->type;
			$POST->EnableAdd = !isset($POST->EnableAdd) ? '' : $POST->EnableAdd;
			$POST->EnableBarcode = !isset($POST->EnableBarcode) ? '' : $POST->EnableBarcode;
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
			

			$query->bindParam(':type',$POST->type);
			$query->bindParam(':EnableAdd',$POST->EnableAdd );
			$query->bindParam(':EnableBarcode',$POST->EnableBarcode );

			$query->execute();	

		}
}

?>