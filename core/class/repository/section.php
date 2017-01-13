<?php 
class SectionRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_section  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_section  WHERE Id = '$id'");
			$query->execute();	
		}
		 public function DataList($CourseYearId,$searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
			
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_section WHERE CourseYearId = '$CourseYearId' AND section LIKE '%$searchText%' $limitCondition");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_section WHERE CourseYearId = '$CourseYearId' ")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
		 public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
		
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$section = $POST->section;
			$CourseYearId  = (!isset($POST->CourseYearId))? 0 : $POST->CourseYearId;
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_section (section,CourseYearId) VALUES(?,?)");
				$query->execute(array($section,$CourseYearId));	
			}else{
				$query = $conn->prepare("UPDATE tbl_section SET section = ?  , CourseYearId = ?   WHERE Id = ? ");
				$query->execute(array($section,$CourseYearId,$id));	
			}

		}
}
 $GLOBALS['SectionRepo'] = new SectionRepository();


?>