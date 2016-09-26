<?php 
class CourseRepository{
		 function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_course  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_course  WHERE Id = '$id'");
			$query->execute();	
		}
		 function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_course WHERE course LIKE '%$searchText%' $limitCondition");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_course")->rowcount();
			
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
			$code = $POST->code;
			$course = $POST->course;
			$description  = (!isset($POST->description))? '' : $POST->description;
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_course (course,description,code) VALUES(?,?,?)");
				$query->execute(array($course,$description,$code));	
			}else{
				$query = $conn->prepare("UPDATE tbl_course SET course = ?  , description = ? , code = ?   WHERE Id = ? ");
				$query->execute(array($course,$description,$code,$id));	
			}

		}
}
$GLOBALS['CourseRepo'] = new CourseRepository();


?>