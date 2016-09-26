<?php 
class TypeRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_type  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_type  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			$query = $conn->query("SELECT * FROM  tbl_type WHERE type LIKE '%$searchText%' ORDER BY type DESC LIMIT $pageNo,$pageSize  ");
			if($searchText != ''){
				$count = $query->rowcount();
			}else{
				$count = $conn->query("SELECT * FROM  tbl_type")->rowcount();
			}
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
			$type = $POST->type;
			//$type = $_POST['type'];
			// $filename = basename($_FILES['file']['name']);
			// $ext = substr($filename, strrpos($filename, '.') + 1);
			// $file = $filename;
			// move_uploaded_file($_FILES['file']['tmp_name'],'../upload/'.$file);
			
			 // $query = $conn->prepare("INSERT INTO tbl_type (type,photo) VALUES(?,?)");
			 // $query->execute(array($type,$file));
			 
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_type (type) VALUES(?)");
				$query->execute(array($type));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_type SET type = ?  WHERE Id = ? ");
				$query->execute(array($type,$id));	
			}
		}
}
$GLOBALS['TypeRepo'] = new TypeRepository();
?>