<?php 
class SemesterRepository{
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
			$where = "";
			if($searchText != ''){
				$where .= "And Semester LIKE '%$searchText%'";
			}
			
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_semester WHERE 1 = 1 $where ORDER BY Semester DESC $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_semester")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_semester (Semester,Current) VALUES(:Semester,:Current)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_semester SET Semester = :Semester , Current = :Current  WHERE Id = :Id ");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Semester = !isset($POST->Semester) ? '' : $POST->Semester;
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
			
			$query->bindParam(':Semester', $POST->Semester);
			$query->bindParam(':Current', $POST->Current);
			$query->execute();	
		}
}


?>