<?php 
class ProductRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_product  WHERE Id = '$id'");
			$query->execute();	
		}
		public function getSoldProduct($ProductId){
				global $conn;
				$query = $conn->query("SELECT *,SUM(qty) as total_qty FROM tbl_product_order WHERE ProductId = '$ProductId' AND confirm = 'Yes'");
				$row = $query->fetch(PDO::FETCH_ASSOC);
				return $row['total_qty'];
		}
		public function DataListByCategory($CategoryId,$searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					
					$limit_conition = $pageNo != 0 ? "LIMIT $pageNo,$pageSize" : "";
					$condition = $CategoryId != 0 ? "AND tbl_product.CategoryId = '$CategoryId'": "" ;
					
					$query = $conn->query("SELECT *,SUM(qty) as stock_qty,tbl_product.Id as Id FROM  tbl_product 
					LEFT JOIN tbl_category ON tbl_category.Id = tbl_product.CategoryId
					LEFT OUTER JOIN tbl_stock ON tbl_product.Id = tbl_stock.ProductId
					WHERE name LIKE '%$searchText%' $condition  GROUP BY tbl_product.Id $limit_conition");
			
					$count =  $query->rowcount();
					$data = array();

					if($count > 0){
						foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row){
								$ProductId = $row['Id'];
								$row['qty'] = (string) ($row['qty'] - $this->getSoldProduct($ProductId));
								$ResultsData[] = $row;
						}
					}else{
						$ResultsData = "";
					}

					
	
					$data['Results'] = $ResultsData;
					$data['Count'] = $count;
					return $data;	
			
		}

		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
					
			$query = $conn->query("SELECT *,SUM(qty) as stock_qty,tbl_product.Id as Id FROM  tbl_product 
			LEFT JOIN tbl_category ON tbl_category.Id = tbl_product.CategoryId
			LEFT OUTER JOIN tbl_stock ON tbl_product.Id = tbl_stock.ProductId
			WHERE name LIKE '%$searchText%'  GROUP BY tbl_product.Id LIMIT $pageNo,$pageSize ");
			
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_product")->rowcount() ;
			$data = array();
			
					if($count > 0){
						foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row){
								$ProductId = $row['Id'];
								$row['qty'] = (string) ($row['qty'] - $this->getSoldProduct($ProductId));
								$ResultsData[] = $row;
						}
					}else{
						$ResultsData = "";
					}

			
			$data['Results'] = $ResultsData;
			$data['Count'] = $count;
			return $data;	
			
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$name =  $POST->name;
			$description =  $POST->description;
			$price =  $POST->price;
			$CategoryId =  $POST->CategoryId;
			$unit =  $POST->unit;
			$product_code =  $POST->product_code;

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_product (name,description,CategoryId,price,product_code,unit) VALUES(?,?,?,?,?,?)");
				$query->execute(array($name,$description,$CategoryId,$price,$product_code,$unit));	
			}else{ 
				$query = $conn->prepare("UPDATE tbl_product SET product_code = ?  , name = ? , description = ? , CategoryId = ? , price = ? , unit = ? WHERE Id = ? ");
				$query->execute(array($product_code,$name,$description,$CategoryId,$price,$unit,$id));	
			}
		}
		
		
		
  	/* stock */
		public function stock_list($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_stock WHERE ProductId = '$id' ORDER BY date_added DESC");
			$count = $query->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function stock_count($id){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) as item_stock FROM tbl_stock WHERE ProductId = '$id' ");
			$row =  $query->fetch();	
			return $row['item_stock'];
		}
		public function add_stock(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$qty =  $POST->qty;
			$ProductId =  $POST->ProductId;

			$date_added = date('Y-m-d');
			$query = $conn->prepare("INSERT INTO tbl_stock (qty,ProductId,date_added) VALUES(?,?,?)");
			$query->execute(array($qty,$ProductId,$date_added));	
		}

	/* end stock */
		
		
		
}		
$GLOBALS['ProductRepo'] = new ProductRepository();	

?>