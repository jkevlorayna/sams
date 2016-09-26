<?php 
class MemberTypeRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_type  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
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
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$type =  $POST->type;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_member_type (type) VALUES(?)");
				$query->execute(array($type));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_member_type SET type = ?   WHERE Id = ? ");
				$query->execute(array($type,$id));	
			}
		}
}
$GLOBALS['MemberTypeRepo'] = new MemberTypeRepository();
?>