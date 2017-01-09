<?php 
class EventRepository{
		 function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_events  WHERE Id = '$id'");
			return	$query->fetch(PDO::FETCH_OBJ);
		}
		 function GetMember($EventId,$MemberId){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_event_details  WHERE EventId = '$EventId' AND MemberId = '$MemberId'");
			return $query->fetch(PDO::FETCH_OBJ);

		}
		 function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_events  WHERE Id = '$id'");
			$query->execute();	
		}
		 function DataList($searchText,$pageNo,$pageSize,$Semester,$SchoolYear,$Status){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
				
						$where = "";
					if($searchText != ''){
						$where .= "And (Name LIKE '%$searchText%' OR Place LIKE '%$searchText%' OR Status = '$searchText')";
					}
					if($Semester != ''){
						$where .= "And Semester = '$Semester'";
					}
					if($SchoolYear != ''){
						$where .= "And SchoolYearId = '$SchoolYear'";
					}
					if($Status != ''){
						$where .= "And Status = '$Semester'";
					}					
							
					
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_events WHERE 1 = 1 $where ORDER BY DateCreated DESC $limitCondition ");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_events ORDER BY DateCreated DESC")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_events (Name,DateCreated,Place,Status,Semester,SchoolYearId,TimeType,EventDate) VALUES(:Name,:DateCreated,:Place,:Status,:Semester,:SchoolYearId,:TimeType,:EventDate)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_events SET Name = :Name  , Place = :Place , Status = :Status , TimeType = :TimeType , EventDate = :EventDate WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name;
			$POST->Place = !isset($POST->Place) ? '' : $POST->Place;
			$POST->Status = !isset($POST->Status) ? '' : $POST->Status;
			$POST->Semester = !isset($POST->Semester) ? '' : $POST->Semester;
			$POST->SchoolYearId = !isset($POST->SchoolYearId) ? '' : $POST->SchoolYearId;
			$POST->TimeType = !isset($POST->TimeType) ? '' : $POST->TimeType;
			$POST->DateCreated = date('Y-m-d');
			$POST->EventDate = !isset($POST->EventDate) ? '0000-00-00' : $POST->EventDate;
			return $POST;
		}
		 function Save($POST){
			global $conn;

			if($POST->Id == 0){
				$query = $this->Create();
				$query->bindParam(':DateCreated', $POST->DateCreated);
				$query->bindParam(':Semester',$POST->Semester );
				$query->bindParam(':SchoolYearId',$POST->SchoolYearId );
			}else{
				$query = $this->Update();
				$query->bindParam(':Id', $POST->Id);

			}
			

			$query->bindParam(':Name',$POST->Name);
			$query->bindParam(':Place',$POST->Place);
			$query->bindParam(':Status',$POST->Status);
			$query->bindParam(':TimeType',$POST->TimeType);
			$query->bindParam(':EventDate',$POST->EventDate);


			$query->execute();	

		}
}
?>