<?php 
class PlaceRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_place  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_place  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_place WHERE name LIKE '%$searchText%'  $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_place")->rowcount() ;

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			

			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$name = (!isset($POST->name)) ? 0 : $POST->name;
			$address = (!isset($POST->address)) ? 0 : $POST->address;
			$geoLocation = (!isset($POST->geoLocation)) ? 0 : $POST->geoLocation;
			$description = (!isset($POST->description)) ? 0 : $POST->description;
			$CategoryId = (!isset($POST->CategoryId)) ? 0 : $POST->CategoryId;


			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_place (name,address,geoLocation,description,CategoryId) VALUES(?,?,?,?,?)");
				$query->execute(array($name,$address,$geoLocation,$description,$CategoryId));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_place SET name = ? , address = ? , geoLocation = ? , description = ? , CategoryId = ?   WHERE Id = ? ");
				$query->execute(array($name,$address,$geoLocation,$description,$CategoryId,$id));	
			}
		}
}
 $GLOBALS['PlaceRepo'] = new PlaceRepository();

?>