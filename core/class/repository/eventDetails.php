<?php 
class EventDetailsRepository{
		 function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_event_details  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_event_details  WHERE Id = '$id'");
			$query->execute();	
		}
		 function DataList($searchText,$pageNo,$pageSize,$EventId){
			global $conn;
			$where = "";
			if($searchText != ''){
				$where .= "And (
				tbl_member.firstname  LIKE '%$searchText%' OR 
				tbl_member.middlename  LIKE '%$searchText%' OR 
				tbl_member.lastname  LIKE '%$searchText%'  
				)";
			}
			$where .= "And EventId = '$EventId'";
			
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;		
			
			$query = $conn->query("SELECT *,tbl_event_details.Id As Id FROM  tbl_event_details 
			LEFT JOIN tbl_member On tbl_event_details.MemberId = tbl_member.Id
			LEFT JOIN tbl_course on tbl_course.Id = tbl_member.CourseId	
			LEFT JOIN tbl_section on tbl_section.Id = tbl_member.SectionId	
			LEFT JOIN tbl_course_year on tbl_course_year.Id = tbl_member.CourseYearId	
			WHERE 1 = 1 $where
			$limitCondition ");
			$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_event_details WHERE EventId = '$EventId' ")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_event_details (MemberId,EventId,InAm,OutAm,InPm,OutPm) VALUES(:MemberId,:EventId,:InAm,:OutAm,:InPm,:OutPm)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_event_details SET MemberId = :MemberId  , EventId = :EventId , InAm = :InAm , OutAm = :OutAm , InPm = :InPm , OutPm = :OutPm WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId;
			$POST->EventId = !isset($POST->EventId) ? '' : $POST->EventId;
			$POST->InAm = !isset($POST->InAm) ? 0 : $POST->InAm;
			$POST->OutAm = !isset($POST->OutAm) ? 0 : $POST->OutAm;
			$POST->InPm = !isset($POST->InPm) ? 0 : $POST->InPm;
			$POST->OutPM = !isset($POST->OutPM) ? 0 : $POST->OutPM;
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
			
			
			$query->bindParam(':MemberId',$POST->MemberId );
			$query->bindParam(':EventId',$POST->EventId );
			$query->bindParam(':InAm',$POST->InAm);
			$query->bindParam(':OutAm',$POST->OutAm);
			$query->bindParam(':InPm',$POST->InPm);
			$query->bindParam(':OutPm',$POST->OutPm);

			$query->execute();	

		}
}
?>