<?php 
class StatusRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_status  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_status  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_status WHERE status LIKE '%$searchText%' $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_status")->rowcount();
			
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
			$status =  $POST->status;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_status (status) VALUES(?)");
				$query->execute(array($status));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_status SET status = ?   WHERE Id = ? ");
				$query->execute(array($status,$id));	
			}
		}
}


?>