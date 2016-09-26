<?php 
class YearRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_year  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_year  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_year WHERE year LIKE '%$searchText%' ORDER BY year DESC  $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_year")->rowcount() ;

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
			$year =  $POST->year;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_year (year) VALUES(?)");
				$query->execute(array($year));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_year SET year = ?   WHERE Id = ? ");
				$query->execute(array($year,$id));	
			}
		}
}
 $GLOBALS['YearRepo'] = new YearRepository();

?>