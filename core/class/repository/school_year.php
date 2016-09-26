<?php 
class SchoolYearRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_school_year  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_school_year  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_school_year  ORDER BY year_from DESC $limitCondition  ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_school_year")->rowcount();;

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
	
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$year_from =  $POST->year_from;
			$year_to =  $POST->year_to;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_school_year (year_from,year_to) VALUES(?,?)");
				$query->execute(array($year_from,$year_to));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_school_year SET year_from = ? , year_to = ?   WHERE Id = ? ");
				$query->execute(array($year_from,$year_to,$id));	
			}
		}
}
 $SchoolYearRepo = new SchoolYearRepository();
?>