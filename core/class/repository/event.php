<?php 
class EventRepository{
		 function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_events  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_events  WHERE Id = '$id'");
			$query->execute();	
		}
		 function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_events WHERE Name LIKE '%$searchText%' ORDER BY DateCreated DESC $limitCondition ");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_events ORDER BY DateCreated DESC")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_events (Name,DateCreated,Place,Status) VALUES(:Name,:DateCreated,:Place,:Status)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_events SET Name = :Name  , Place = :Place , Status = :Status WHERE Id = :Id ");
			return $query;
			
		}	
		 function Save($POST){
			global $conn;

			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			$query->bindParam(':Name', !isset($POST->Name) ? '' : $POST->Name );
			$query->bindParam(':Place', !isset($POST->Place) ? '' : $POST->Place );
			$query->bindParam(':Status', !isset($POST->Status) ? '' : $POST->Status );
			if($Id == 0){ $query->bindParam(':DateCreated', date('Y-m-d')); }
			

			$query->execute();	

		}
}
?>