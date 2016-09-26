<?php 
class DepartmentRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_department  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_department  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_department WHERE department LIKE '%$searchText%' $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() :  $conn->query("SELECT * FROM  tbl_department")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$department =  $POST->department;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_department (department) VALUES(?)");
				$query->execute(array($department));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_department SET department = ?   WHERE Id = ? ");
				$query->execute(array($department,$id));	
			}
		}
}
$GLOBALS['DepartmentRepo'] = new DepartmentRepository();
?>