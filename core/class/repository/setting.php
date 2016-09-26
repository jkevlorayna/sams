<?php 
class SettingRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_setting  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_setting  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_setting  $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_setting")->rowcount();
			
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
			$title =  $POST->title;
			$settingKey =  $POST->settingKey;
			$value =  $POST->value;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_setting (title,settingKey,value) VALUES(?,?,?)");
				$query->execute(array($title,$settingKey,$value));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_setting SET title = ? , settingKey = ? , value = ?   WHERE Id = ? ");
				$query->execute(array($title,$settingKey,$value,$id));	
			}
		}
}
$GLOBALS['SettingRepo'] = new SettingRepository();
?>