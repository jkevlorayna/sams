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
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		 public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id  = (!isset($POST->id))? 0 : $POST->id;
			$CourseId = $POST->CourseId;
			$year = $POST->year;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_course_year (CourseId,year) VALUES(?,?)");
				$query->execute(array($CourseId,$year));	
			}else{
				$query = $conn->prepare("UPDATE tbl_course_year SET year = ?   WHERE Id = ? ");
				$query->execute(array($year,$id));	
			}

		}
}
$GLOBALS['CourseYearRepo'] = new CourseYearRepository();



?>