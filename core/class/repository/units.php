<?php 
class UnitRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_units  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_units  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_units WHERE units LIKE '%$searchText%' $limitCondition");
			$count = $searchText != '' ? $query->rowcount() :  $conn->query("SELECT * FROM  tbl_units")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function units_save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
		
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$units =  $POST->units;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_units (units) VALUES(?)");
				$query->execute(array($units));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_units SET units = ?   WHERE Id = ? ");
				$query->execute(array($units,$id));	
			}
		}
}
$GLOBALS['UnitRepo'] = new UnitRepository();
?>