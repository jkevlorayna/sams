<?php 
class SubjectRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_subject  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_subject  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_subject WHERE subject LIKE '%$searchText%' $limitCondition  ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_subject")->rowcount();

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
			$subject =  $POST->subject;
			$code  = (!isset($POST->code))? 0 : $POST->code;
			$unit  = (!isset($POST->unit))? 0 : $POST->unit;
			$CourseYearId  = (!isset($POST->CourseYearId))? 0 : $POST->CourseYearId;
			
			
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_subject (subject,code,unit,CourseYearId) VALUES(?,?,?,?)");
				$query->execute(array($subject,$code,$unit,$CourseYearId));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_subject SET subject = ? , code = ? , unit = ?  , CourseYearId = ?  WHERE Id = ? ");
				$query->execute(array($subject,$code,$unit,$CourseYearId,$id));	
			}
		}
}
$GLOBALS['SubjectRepo'] = new SubjectRepository();
?>