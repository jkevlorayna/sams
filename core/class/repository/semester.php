<?php 
class SemesterRepository{
		public function GetByName($search){
			global $conn;
					$searchText = $_GET['searchText'];
					$pageNo = $_GET['pageNo'];
					$pageSize = $_GET['pageSize'];
			$pageNo = ($pageNo - 1) * $pageSize; 
			$query = $conn->query("SELECT * FROM tbl_semester  WHERE semester = '$searchText' LIMIT $pageNo,$pageSize ");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_semester  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_semester  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					
				    $limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
				    $query = $conn->query("SELECT * FROM  tbl_semester WHERE semester LIKE '%$searchText%' ORDER BY semester DESC $limitCondition");
				    $count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_semester")->rowcount();
			
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
			$semester =  $POST->semester;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_semester (semester) VALUES(?)");
				$query->execute(array($semester));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_semester SET semester = ?   WHERE Id = ? ");
				$query->execute(array($semester,$id));	
			}
		}
}
$GLOBALS['SemesterRepo'] = new SemesterRepository();

?>