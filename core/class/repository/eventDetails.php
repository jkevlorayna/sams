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
		 function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_event_details WHERE MemberId LIKE '%$searchText%' $limitCondition ");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_event_details")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_event_details (MemberId,EventId) VALUES(:MemberId,:EventId)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_event_details SET MemberId = :MemberId  , EventId = :EventId WHERE Id = :Id ");
			return $query;
			
		}	
		function Save($POST){
			global $conn;

			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			$query->bindParam(':MemberId', !isset($POST->MemberId) ? 0 : $POST->MemberId );
			$query->bindParam(':EventId', !isset($POST->EventId) ? 0 : $POST->EventId );

			$query->execute();	

		}
}
?>