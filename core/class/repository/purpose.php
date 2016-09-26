<?php 
class PurposeRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_purpose  WHERE purpose_id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_purpose  WHERE purpose_id = '$id'");
			$query->execute();	
		}
		public function DataList(){
			global $conn;
					$searchText = $_GET['searchText'];
					$pageNo = $_GET['pageNo'];
					$pageSize = $_GET['pageSize'];
					$pageNo = ($pageNo - 1) * $pageSize; 
			
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_purpose WHERE purpose LIKE '%$searchText%' ORDER BY purpose DESC $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_purpose")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
	
			$id  = (!isset($POST->purpose_id))? 0 : $POST->purpose_id;
			$purpose =  $POST->purpose;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_purpose (purpose) VALUES(?)");
				$query->execute(array($purpose));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_purpose SET purpose = ?   WHERE purpose_id = ? ");
				$query->execute(array($purpose,$id));	
			}
		}
}
 $GLOBALS['PurposeRepo'] = new PurposeRepository();
?>