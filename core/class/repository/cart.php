<?php
class CartRepository{
		 public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_product_order  WHERE Id = '$id'");
			$query->execute();	
		}
		public function Add(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$ProductId =  $POST->ProductId;
			$MemberId =  $POST->MemberId;
		
			if($id == 0) { 
				$qty = (!isset($POST->UserQty)) ? 0 : $POST->UserQty;
				$query = $conn->prepare("INSERT INTO tbl_product_order (ProductId,MemberId,qty) VALUES(?,?,?)");
				$query->execute(array($ProductId,$MemberId,$qty));	
			}else{
				$qty = (!isset($POST->qty)) ? 0 : $POST->qty;
				$query = $conn->prepare("UPDATE tbl_product_order SET qty = ?  WHERE Id = ? ");
				$query->execute(array($qty,$id));	
			}

		}
		
		public function MemberOrderList($MemberId){
			global $conn;
			$query = $conn->query("SELECT *,tbl_product_order.Id as Id FROM tbl_product_order 
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE MemberId  = '$MemberId' AND confirm != 'Yes' ");
			$count = $query->rowcount();

			$query1 = $conn->query("SELECT *,SUM(price * tbl_product_order.qty) as total_price,tbl_product_order.Id as Id FROM tbl_product_order 
			LEFT JOIN tbl_product ON tbl_product.Id = tbl_product_order.ProductId
			WHERE MemberId  = '$MemberId' AND confirm != 'Yes'  ");
			$row1 = $query1->fetch(PDO::FETCH_ASSOC);
			
			
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			$data['grandTotal'] = $row1['total_price'];
			return $data;	
			
		}
			
	 public function gencode($number){
		global $conn;
	
		$x=1; 
		while($x<=$number) {
		$chars ="123456789";//length:36
		$final_rand='';
		for($i=0;$i<7; $i++)
		{
			$final_rand .= $chars[ rand(0,strlen($chars)-1)];
		}
		return $pin =  $final_rand;

		$x++;
		} 
	}
	 public function sendOrder(){
		   session_start();
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$order_code = $this->gencode(8);
			$date_order = date('Y-m-d');
			$time_order = date("H:i");
			$MemberId = $_SESSION['Id'];
			foreach($POST as $row){
 			  $query = $conn->prepare("UPDATE tbl_product_order SET confirm = ? , order_code = ?  WHERE Id = ?");
				$query->execute(array('Yes',$order_code,$row->Id));	
			}

			$query = $conn->prepare("INSERT INTO tbl_member_order  (order_code,MemberId,order_status,date_order,time_order) VALUES(?,?,?,?,?)");
			$query->execute(array($order_code,$MemberId,'pending',$date_order,$time_order));	

		}
}
$GLOBALS['CartRepo'] = new CartRepository();	

?>