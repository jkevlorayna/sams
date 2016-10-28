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
			$where = "";
			if($searchText != ''){
				$where .= "And (YearFrom LIKE '%$searchText%' OR YearTo LIKE '%$searchText%')";
			}

			
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_school_year WHERE 1 = 1 $where  ORDER BY YearFrom DESC $limitCondition  ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_school_year")->rowcount();;

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_school_year (YearFrom,YearTo,Current) VALUES(:YearFrom,:YearTo,:Current)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_school_year SET YearFrom = :YearFrom , YearTo = :YearTo , Current = :Current  WHERE Id = :Id ");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->YearFrom = !isset($POST->YearFrom) ? 0 : $POST->YearFrom;
			$POST->YearTo = !isset($POST->YearTo) ? 0 : $POST->YearTo;
			$POST->Current = !isset($POST->Current) ? 0 : $POST->Current;
			return $POST;
		}
		public function Save($POST){
			global $conn;

			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->Update();
				$query->bindParam(':Id', $POST->Id);
			}
			
			$query->bindParam(':YearFrom', $POST->YearFrom);
			$query->bindParam(':YearTo', $POST->YearTo);
			$query->bindParam(':Current', $POST->Current);
			$query->execute();	
		}
}
?>