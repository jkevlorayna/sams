<?php 
class CourseYearRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_course_year  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_course_year  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DeleteByCourse($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_course_year  WHERE CourseId = '$id'");
			$query->execute();	
		}
		public function DataList($CourseId,$searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;		
			$query = $conn->query("SELECT * FROM  tbl_course_year WHERE CourseId = '$CourseId' AND year LIKE '%$searchText%' $limitCondition ");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_course_year WHERE CourseId = '$CourseId' ")->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_course_year (CourseId,year) VALUES(:CourseId,:year)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_course_year SET CourseId = :CourseId  , year = :year  WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->CourseId = !isset($POST->CourseId) ? 0 : $POST->CourseId;
			$POST->year = !isset($POST->year) ? 0 : $POST->year;
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
			
			$query->bindParam(':CourseId',$POST->CourseId);
			$query->bindParam(':year',$POST->year);
			$query->execute();	

		}
}
?>