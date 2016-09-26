<?php
class OrderRepository{
		public function orderReport($date_from,$date_to){
			global $conn;

			$query = $conn->query("SELECT *,SUM(price * tbl_product_order.qty) as total_price,tbl_member_order.Id AS Id FROM tbl_member_order 
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_member_order.MemberId
			LEFT JOIN tbl_product_order ON tbl_product_order.order_code = tbl_member_order.order_code
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE  confirm = 'Yes' AND date_order BETWEEN '$date_from' AND '$date_to'
			GROUP BY tbl_member_order.Id   ");
			$QueryResult =  $query->fetchAll(PDO::FETCH_ASSOC);
			$grandTotal = 0;
			foreach($QueryResult as $row){
				$grandTotal += $row['total_price'];
			}
			
			$data = array();
			$data['Results'] = $QueryResult;
			$data['GrandTotal'] = $grandTotal;
			return $data;
		
		}

		public function orderlistAdmin($OrderList,$searchText,$pageNo,$pageSize){
			global $conn;
					$OrderList = $OrderList == 'all' ? '' : $OrderList ;
					$pageNo = ($pageNo - 1) * $pageSize; 
					
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;

			$query = $conn->query("SELECT *,SUM(price * tbl_product_order.qty) as total_price,tbl_member_order.Id AS Id FROM tbl_member_order 
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_member_order.MemberId
			LEFT JOIN tbl_product_order ON tbl_product_order.order_code = tbl_member_order.order_code
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE order_status LIKE '%$OrderList%' AND confirm = 'Yes'
			GROUP BY tbl_member_order.Id 
			ORDER BY date_order $limitCondition ");
		
			$count = $searchText != '' ? $count = $query->rowcount() : $conn->query("SELECT * FROM  tbl_member_order")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;
		
		}
		public function orderlist($MemberId){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order WHERE MemberId  = '$MemberId' ");
			return $query->fetchAll(PDO::FETCH_ASSOC);			
		}
		public function getOrder($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order WHERE Id  = '$id' ");
			$memberOrder = $query->fetch(PDO::FETCH_ASSOC);	
			$order_code = $memberOrder['order_code'];

			$query = $conn->query("SELECT *,tbl_product_order.Id as Id FROM tbl_product_order 
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE order_code  = '$order_code' AND confirm = 'Yes' ");
			$count = $query->rowcount();

			$query1 = $conn->query("SELECT *,SUM(price * tbl_product_order.qty) as total_price,tbl_product_order.Id as Id FROM tbl_product_order 
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE order_code  = '$order_code' AND confirm = 'Yes'  ");
			$row1 = $query1->fetch(PDO::FETCH_ASSOC);
			
		
			$data['Order'] = $memberOrder;
			$data['OrderData'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			$data['grandTotal'] = $row1['total_price'];
			
			
			return $data;	
		}
		public function saveOrder(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$order_status =  $POST->order_status;
			
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_member_order (order_status) VALUES(?)");
				$query->execute(array($order_status));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_member_order SET order_status = ?   WHERE Id = ? ");
				$query->execute(array($order_status,$id));	
			}
			
		}
}		
$GLOBALS['OrderRepo'] = new OrderRepository();

?>