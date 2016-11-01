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

		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_course (course,description,code) VALUES(:course,:description,:code)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_course SET course = :course  , description = :description , code = :code  WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->course = !isset($POST->course) ? '' : $POST->course;
			$POST->description = !isset($POST->description) ? '' : $POST->description;
			$POST->code = !isset($POST->code) ? '' : $POST->code;
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
			$query->bindParam(':course',$POST->course);
			$query->bindParam(':description',$POST->description);
			$query->bindParam(':code',$POST->code);
			$query->execute();	
		}
}
?>