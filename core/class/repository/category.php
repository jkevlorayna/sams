<?php 
class CategoryRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_category  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_category  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_category WHERE category_name LIKE '%$searchText%' $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_category")->rowcount();
					
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
			$category_name = $POST->category_name;
			$category_desc = (!isset($POST->category_desc)) ? 0 : $POST->category_desc;
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_category (category_name,category_desc) VALUES(?,?)");
				$query->execute(array($category_name,$category_desc));	
			}else{
				$query = $conn->prepare("UPDATE tbl_category SET category_name = ?  , category_desc = ?  WHERE Id = ? ");
				$query->execute(array($category_name,$category_desc,$id));	
			}

		}
}
?>