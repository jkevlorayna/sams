<?php 
class OrganizationRepository{
		 function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_organization  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_organization  WHERE Id = '$id'");
			$query->execute();	
		}
		 function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			
			$where = "";
			if($searchText != ''){
				$where .= "AND Name LIKE '%$searchText%' OR Code LIKE '%$searchText%'";
			}
			
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;					
					$query = $conn->query("SELECT * FROM  tbl_organization WHERE 1 = 1 $where $limitCondition");
					$count = $searchText != '' ?   $query->rowcount() : $conn->query("SELECT * FROM  tbl_organization")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}

		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_organization (Name,Code) VALUES(:Name,:Code)");
			return $query;
		}	
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_organization SET Name = :Name  , Code = :Code  WHERE Id = :Id ");
			return $query;
			
		}	
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name;
			$POST->Code = !isset($POST->Code) ? '' : $POST->Code;
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
			$query->bindParam(':Name',$POST->Name);
			$query->bindParam(':Code',$POST->Code);
			$query->execute();	
		}
}
?>