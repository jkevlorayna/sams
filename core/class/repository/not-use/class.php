<?php 
include('dbcon.php'); 
include('functions/generic.php');
class system_class extends generic{
		/* sales report */
		public function sales_report($status,$condition){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order LEFT JOIN tbl_member ON tbl_member_order.member_id = tbl_member.member_id 
			WHERE order_status = '$status' $condition ORDER BY date_order,time_order DESC");
			return $query->fetchAll();	
		}
		public function sales_report_count($status,$condition){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order LEFT JOIN tbl_member ON tbl_member_order.member_id = tbl_member.member_id 
			WHERE order_status = '$status' $condition ORDER BY date_order,time_order DESC");
			return $query->rowcount();	
		}
		public function sales_report_details($order_code){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product_order 
			LEFT JOIN tbl_product ON  tbl_product.product_id = tbl_product_order.product_id
			WHERE order_code = '$order_code' ");

			$total_amount = 0;
			foreach($query->fetchAll() as $row){
			$amount = number_format($row['qty'] * $row['price'] , 2 );
			$total_amount += $amount;
			$id = $row['product_order_id'];
			
			}
			return $total_amount;
		}
		
	/*  end sales report  */
	
		/* reservation  */
		public function member_res_count($session_id,$confirm){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) as total_res FROM tbl_service_res WHERE member_id = '$session_id' AND confirm = '$confirm' ");
			$row = $query->fetch();	
			return $row['total_res'];
		}
		public function send_reservation($POST){
			global $conn;
			$service_res_id = $POST['service_res_id'];
			$order_code = $this->gencode(8);
			$member_id = $_POST['member_id'];
			$staff_id = $_POST['staff_id'];
			$schedule_date = $_POST['schedule_date'];
			$date_order = date('Y-m-d');
			$time_order = date("H:i");
			
			foreach($service_res_id as $service_res_id){
 				$query = $conn->prepare("UPDATE tbl_service_res SET confirm = ? , order_code = ?  WHERE service_res_id = ?");
				$query->execute(array('Yes',$order_code,$service_res_id));	
			}

			$query = $conn->prepare("INSERT INTO tbl_member_res  (order_code,member_id,order_status,date_order,time_order,staff_id,schedule_date) VALUES(?,?,?,?,?,?,?)");
			$query->execute(array($order_code,$member_id,'pending',$date_order,$time_order,$staff_id,$schedule_date));	

		}
		public function add_reservation_list($POST){
			global $conn;
			$service_id = $POST['service_id'];
			$member_id = $POST['member_id'];
			$qty = $POST['qty'];
			$query = $conn->prepare("INSERT INTO tbl_service_res (member_id,service_id,qty) VALUES(?,?,?)");
			$query->execute(array($member_id,$service_id,$qty));
		}
		public function member_reservation_count($session_id,$confirm){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) as total_order FROM tbl_service_res WHERE member_id = '$session_id' AND confirm = '$confirm' ");
			$row = $query->fetch();	
			return $row['total_order'];
		}
		public function member_reservation_list($session_id,$confirm){
					global $conn;
					$query = $conn->query("SELECT * FROM tbl_service_res 
					LEFT JOIN tbl_service ON  tbl_service.service_id = tbl_service_res.service_id
					WHERE member_id = '$session_id'  AND confirm  = '$confirm' ");
					return $query->fetchAll();	
		}
		public function delete_res_service($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_service_res WHERE service_res_id = '$id'");
			$query->execute();	
		}
		public function my_res($session_id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_res
			LEFT JOIN tbl_staff ON tbl_staff.staff_id = tbl_member_res.staff_id
			WHERE member_id = '$session_id' ORDER BY date_order DESC , time_order DESC");
			return $query->fetchAll();	
		}
		public function member_res_list_by_code($order_code){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_service_res 
			LEFT JOIN tbl_service ON  tbl_service.service_id = tbl_service_res.service_id
			WHERE order_code = '$order_code' ");
			return $query->fetchAll();	
		}
		public function my_res_admin_all(){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_res 
			LEFT JOIN tbl_member ON tbl_member_res.member_id = tbl_member.member_id 
			LEFT JOIN tbl_staff ON tbl_staff.staff_id = tbl_member_res.staff_id 
			ORDER BY date_order DESC , time_order DESC
			");
			return $query->fetchAll();	
		}
		public function my_res_admin($order_status){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_res
			LEFT JOIN tbl_member ON tbl_member_res.member_id = tbl_member.member_id 
			LEFT JOIN tbl_staff ON tbl_staff.staff_id = tbl_member_res.staff_id 
			WHERE order_status = '$order_status'
			ORDER BY date_order DESC , time_order DESC
			");
			return $query->fetchAll();	
		}
		public function update_member_res_status($POST){
			global $conn;
			$id = $POST['id'];
			$order_status = $POST['order_status'];
		
			$query = $conn->prepare("UPDATE tbl_member_res SET order_status = ?  WHERE member_res_id = ? ");
			$query->execute(array($order_status,$id));		
		}
		/* end reservation  */
		
		/* order */
		public function check_product_order_inventory_report($product_id,$condition){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) AS total_qty FROM tbl_product_order 
			LEFT JOIN tbl_member_order ON tbl_product_order.order_code = tbl_member_order.order_code
			WHERE product_id = '$product_id' $condition ");
			$row =  $query->fetch();	
		
			if($row['total_qty'] == ''){
				return 0;
			}else{
				return $order_item =  $row['total_qty'];
			}
		}
		public function check_product_order($product_id){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) AS total_qty FROM tbl_product_order   WHERE product_id = '$product_id' ");
			$row =  $query->fetch();	
			return $order_item =  $row['total_qty'];
		}
		public function update_member_order_status($POST){
			global $conn;
			$id = $POST['id'];
			$order_status = $POST['order_status'];
		
			$query = $conn->prepare("UPDATE tbl_member_order SET order_status = ?  WHERE member_order_id = ? ");
			$query->execute(array($order_status,$id));		
		}
		public function my_order_admin_all(){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order 
			LEFT JOIN tbl_member ON tbl_member_order.member_id = tbl_member.member_id 
			ORDER BY date_order DESC , time_order DESC
			");
			return $query->fetchAll();	
		}
		public function my_order_admin($order_status){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order
			LEFT JOIN tbl_member ON tbl_member_order.member_id = tbl_member.member_id WHERE order_status = '$order_status'
			ORDER BY date_order DESC , time_order DESC
			");
			return $query->fetchAll();	
		}
		public function update_order_qty($POST){
			global $conn;
			$id = $POST['id'];
			$qty = $POST['qty'];
			$query = $conn->prepare("UPDATE tbl_product_order SET qty = ? WHERE product_order_id = ? ");
			$query->execute(array($qty,$id));	
		}
		public function my_order($session_id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member_order WHERE member_id = '$session_id' ORDER BY date_order DESC , time_order DESC");
			return $query->fetchAll();	
		}
		public function member_order_list_by_code($order_code){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product_order 
			LEFT JOIN tbl_product ON  tbl_product.product_id = tbl_product_order.product_id
			WHERE order_code = '$order_code' ");
			return $query->fetchAll();	
		}
		public function order($POST){
			global $conn;
			$product_id = $POST['product_id'];
			$member_id = $POST['member_id'];
			$qty = $POST['qty'];
			$query = $conn->prepare("INSERT INTO tbl_product_order (member_id,product_id,qty) VALUES(?,?,?)");
			$query->execute(array($member_id,$product_id,$qty));
			$item_order_id = $conn->lastInsertId();	
		}
		public function member_order_count($session_id,$confirm){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) as total_order FROM tbl_product_order WHERE member_id = '$session_id' AND confirm = '$confirm' ");
			$row = $query->fetch();	
			return $row['total_order'];
		}
		public function member_order_list($session_id,$confirm){
					global $conn;
					$query = $conn->query("SELECT * FROM tbl_product_order 
					LEFT JOIN tbl_product ON  tbl_product.product_id = tbl_product_order.product_id
					WHERE member_id = '$session_id'  AND confirm  = '$confirm' ");
					return $query->fetchAll();	
				}
		public function send_order($POST){
			global $conn;
			$product_order_id = $POST['product_order_id'];
			$order_code = $this->gencode(8);
			$member_id = $_POST['member_id'];
			$date_order = date('Y-m-d');
			$time_order = date("H:i");
			
			foreach($product_order_id as $product_order_id){
 				$query = $conn->prepare("UPDATE tbl_product_order SET confirm = ? , order_code = ?  WHERE product_order_id = ?");
				$query->execute(array('Yes',$order_code,$product_order_id));	
			}

			$query = $conn->prepare("INSERT INTO tbl_member_order  (order_code,member_id,order_status,date_order,time_order) VALUES(?,?,?,?,?)");
			$query->execute(array($order_code,$member_id,'pending',$date_order,$time_order));	

		}
		public function delete_order_product($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_product_order WHERE product_order_id = '$id'");
			$query->execute();	
		}
		/* end order */
		/*  member  */
		public function signup($POST){
			global $conn;
			$firstname = $POST['firstname'];
			$lastname = $POST['lastname'];
			$middlename = $POST['middlename'];
			$gender = $POST['gender'];
			$email = $POST['email'];
			$mobile_no = $POST['mobile_no'];
			$address = $POST['address'];
			$username = $POST['username'];
			$password = $POST['password'];
			$c_password = $POST['c_password'];
			$date_registered = date('Y-m-d');

			
			$query = $conn->prepare("INSERT INTO tbl_member (firstname,lastname,middlename,gender,email,mobile_no,address,username,password,date_registered) VALUES(?,?,?,?,?,?,?,?,?,?)");
			$query->execute(array($firstname,$lastname,$middlename,$gender,$email,$mobile_no,$address,$username,$password,$date_registered));	
		}
		
		public function selected_member($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member  WHERE member_id = '$id'");
			return $query->fetch();	
		}
		public function delete_member($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member WHERE member_id = '$id'");
			$query->execute();	
		}
		public function member_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member");
			return $query->fetchAll();	
		}
		public function member_count(){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member");
			return $query->rowcount();	
		}
		/* end member */
	
		/* student */
		public function selected_student_by_id_number_count($id_number){
			global $conn;
			$query = $conn->query("SELECT * FROM student  WHERE id_number = '$id_number'");
			return $query->rowcount();	
		}
		public function selected_student_by_id_number($id_number){
			global $conn;
			$query = $conn->query("SELECT * FROM student 
			LEFT JOIN  course ON course.course_id = student.course_id 
			LEFT JOIN  year ON year.year_id = student.year_id 
			LEFT JOIN  section ON section.section_id = student.section_id 
			WHERE id_number = '$id_number'");
			return $query->fetch();	
		}
		public function selected_student($id){
			global $conn;
			$query = $conn->query("SELECT * FROM student  WHERE student_id = '$id'");
			return $query->fetch();	
		}
		public function delete_student($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  student WHERE student_id = '$id'");
			$query->execute();	
		}
		public function student_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  student 
			LEFT JOIN  course ON course.course_id = student.course_id 
			LEFT JOIN  year ON year.year_id = student.year_id 
			LEFT JOIN  section ON section.section_id = student.section_id 
			");
			return $query->fetchAll();	
		}
		public function add_student($POST){
			global $conn;
			$name = $POST['name'];
			$id_number = $POST['id_number'];
			$course_id = $POST['course_id'];
			$year_id = $POST['year_id'];
			$section_id = $POST['section_id'];
			
			$query = $conn->prepare("INSERT INTO student (name,id_number,course_id,year_id,section_id) VALUES(?,?,?,?,?)");
			$query->execute(array($name,$id_number,$course_id,$year_id,$section_id));	
		}
		public function update_student($POST){
			global $conn;
			$id = $POST['id'];
			$name = $POST['name'];
			$id_number = $POST['id_number'];
			$course_id = $POST['course_id'];
			$year_id = $POST['year_id'];
			$section_id = $POST['section_id'];
			
			$query = $conn->prepare("UPDATE student SET name = ? , id_number = ? , course_id = ? , year_id = ? , section_id = ? WHERE student_id = ? ");
			$query->execute(array($name,$id_number,$course_id,$year_id,$section_id,$id));	
		}
	/* end section */
	
	
	/* transaction */
		public function selected_transaction($id){
			global $conn;
			$query = $conn->query("SELECT * FROM transaction  WHERE transaction_id = '$id'");
			return $query->fetch();	
		}
		public function delete_transaction($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  transaction WHERE transaction_id = '$id'");
			$query->execute();	
		}
		public function transaction_list_by_user($user_id,$t_date){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction
			LEFT JOIN transaction ON daily_transaction.transaction_id = transaction.transaction_id
			LEFT JOIN course ON daily_transaction.course_id = course.course_id
			LEFT JOIN year ON daily_transaction.year_id = year.year_id
			LEFT JOIN section ON daily_transaction.section_id = section.section_id
			WHERE user_id = '$user_id' AND t_date = '$t_date' ");
			return $query->fetchAll();	
		}
		public function transaction_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  transaction  ");
			return $query->fetchAll();	
		}
		public function add_transaction($POST){
			global $conn;
			$transaction = $POST['transaction'];
			$query = $conn->prepare("INSERT INTO transaction (transaction) VALUES(?)");
			$query->execute(array($transaction));	
		}

		public function update_transaction($POST){
			global $conn;
			$id = $POST['id'];
			$transaction = $POST['transaction'];
			$query = $conn->prepare("UPDATE transaction SET transaction = ?   WHERE transaction_id = ? ");
			$query->execute(array($transaction,$id));	
		}
	/* end transaction */
	

	
	/* announcement */
		public function selected_announcement($id){
			global $conn;
			$query = $conn->query("SELECT * FROM announcement  WHERE announcement_id = '$id'");
			return $query->fetch();	
		}
		public function delete_announcement($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  announcement WHERE announcement_id = '$id'");
			$query->execute();	
		}
		public function announcement_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  announcement  ");
			return $query->fetchAll();	
		}
		public function add_announcement($POST){
			global $conn;
			$announcement = $POST['announcement'];
			$query = $conn->prepare("INSERT INTO announcement (announcement) VALUES(?)");
			$query->execute(array($announcement));	
		}
		public function update_announcement($POST){
			global $conn;
			$id = $POST['id'];
			$announcement = $POST['announcement'];
			$query = $conn->prepare("UPDATE user SET announcement = ?   WHERE announcement_id = ? ");
			$query->execute(array($announcement,$id));	
		}
	/* end announcement */
	

	/* video */
		public function selected_video($id){
			global $conn;
			$query = $conn->query("SELECT * FROM video  WHERE video_id = '$id'");
			return $query->fetch();	
		}
		public function delete_video($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  video WHERE video_id = '$id'");
			$query->execute();	
		}
		public function video_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  video");
			return $query->fetchAll();	
		}
		public function current_video($status){
			global $conn;
			$query = $conn->query("SELECT * FROM  video WHERE status = '$status'");
			return $query->fetch();	
		}
		public function add_video($POST){
			global $conn;
			$video = $POST['video'];
				    	$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("INSERT INTO video (video,file) VALUES(?,?)");
			$query->execute(array($video,$file));	
		}
		public function update_video($POST){
			global $conn;
			$id = $POST['id'];
			$status = $POST['status'];
			$query = $conn->prepare("UPDATE video SET status = ?   WHERE video_id = ? ");
			$query->execute(array($status,$id));	
		}
	/* end video */
	

	/* daily transaction */
		public function reset($POST){
			global $conn;
			$t_no = 0;
			$t_date = date('Y-m-d');
			$t_time = date('H:i:s');
			$t_type = 'reset';
			
			$query = $conn->prepare("INSERT INTO daily_transaction (t_date,t_time,t_no,t_type) VALUES(?,?,?,?)");
			$query->execute(array($t_date,$t_time,$t_no,$t_type));	
		}
		public function selected_daily_transaction($id){
			global $conn;
			$query = $conn->query("SELECT * FROM daily_transaction  WHERE daily_transaction_id = '$id'");
			return $query->fetch();	
		}
		public function delete_daily_transaction($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  daily_transaction WHERE daily_transaction_id = '$id'");
			$query->execute();	
		}
		public function daily_transaction_count($date){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction  WHERE t_date = '$date'
			");
			return $query->rowcount();	
		}
		public function last_t_no(){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction ORDER BY t_date DESC , t_time DESC , t_no DESC");
			$row =  $query->fetch();	
			return $row['t_no'];
		}
		public function user_current_number($user_id,$date){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction 
			WHERE user_id = '$user_id' AND t_date = '$date' ORDER BY t_date DESC , t_time DESC  , t_no DESC ");
			$row =  $query->fetch();	
			return $row['t_no'];
		}
		public function daily_transaction_list($condition){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction 
			LEFT JOIN transaction ON daily_transaction.transaction_id = transaction.transaction_id
			LEFT JOIN course ON daily_transaction.course_id = course.course_id
			LEFT JOIN year ON daily_transaction.year_id = year.year_id
			LEFT JOIN section ON daily_transaction.section_id = section.section_id
			WHERE $condition  AND  daily_transaction.transaction_id != '0' ORDER BY t_date DESC , t_time DESC 
			");
			return $query->fetchAll();	
		}
		public function daily_transaction_list_by_user($condition,$user_id){
			global $conn;
			$query = $conn->query("SELECT * FROM  daily_transaction 
			LEFT JOIN transaction ON daily_transaction.transaction_id = transaction.transaction_id
			LEFT JOIN course ON daily_transaction.course_id = course.course_id
			LEFT JOIN year ON daily_transaction.year_id = year.year_id
			LEFT JOIN section ON daily_transaction.section_id = section.section_id
			WHERE $condition  AND  daily_transaction.transaction_id != '0' AND user_id = '$user_id' ORDER BY t_date DESC , t_time DESC 
			");
			return $query->fetchAll();	
		}
		public function get_transaction($POST){
			global $conn;
			$date = date('Y-m-d');
			 $count = $this->daily_transaction_count($date);
			if ($count == 0){
				$count = 1;
			}else{
				$max_number = $this->setting_by_code('max_number');
				$count = $this->last_t_no();
				if($max_number == $count){
					$count = 1;
				}else{
					$count = $count + 1;
				}
					
			}
			$t_no = $count;
			$t_date = date('Y-m-d');
			$t_time = date('H:i:s');
			$user_id = $_POST['user_id'];
			
			$query = $conn->prepare("INSERT INTO daily_transaction (t_date,t_time,t_no,user_id) VALUES(?,?,?,?)");
			$query->execute(array($t_date,$t_time,$t_no,$user_id));	
			
			$id = $conn->lastinsertID();
			$row = $this->selected_daily_transaction($id);
			
			echo 'page.php?page=daily_transaction&t_no='.$row['t_no'].'&id='.$row['daily_transaction_id'].'&t_type=student';
		}
		public function add_daily_transaction($POST){
			global $conn;
			$transaction_id = $POST['transaction_id'];
			$student_name = $POST['student_name'];
			$t_no = $POST['t_no'];
			$t_date = date('Y-m-d');
			$t_time = date('H:i:s');
			
			$query = $conn->prepare("INSERT INTO daily_transaction (transaction_id,t_date,t_time,student_name,t_no) VALUES(?,?,?,?,?)");
			$query->execute(array($transaction_id,$t_date,$t_time,$student_name,$t_no));	
		}
		public function update_daily_transaction($POST){
			global $conn;
			$id = $POST['id'];
			$transaction_id = $POST['transaction_id'];
			$student_name = $POST['student_name'];
			$course_id = $POST['course_id'];
			$year_id = $POST['year_id'];
			$section_id = $POST['section_id'];
			$t_type = $POST['t_type'];
			
			$query = $conn->prepare("UPDATE daily_transaction SET transaction_id = ? , student_name = ? , course_id = ? , year_id = ? , section_id = ? , t_type = ?    WHERE daily_transaction_id = ? ");
			$query->execute(array($transaction_id,$student_name,$course_id,$year_id,$section_id,$t_type,$id));	
		}
	/* end transaction */
	
	/* setting */
		public function setting_by_code($code){
			global $conn;
			$query = $conn->query("SELECT * FROM setting  WHERE setting_code = '$code'");
			$row =  $query->fetch();	
			return $row['value'];
		}
		public function selected_setting($id){
			global $conn;
			$query = $conn->query("SELECT * FROM setting  WHERE setting_id = '$id'");
			return $query->fetch();	
		}
		public function delete_setting($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  setting WHERE setting_id = '$id'");
			$query->execute();	
		}
		public function setting_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  setting  ");
			return $query->fetchAll();	
		}
		public function add_setting($POST){
			global $conn;
			$value = $POST['value'];
			$query = $conn->prepare("INSERT INTO setting (value) VALUES(?)");
			$query->execute(array($value));	
		}
		public function update_setting($POST){
			global $conn;
			$id = $POST['id'];
			$value = $POST['value'];
			$query = $conn->prepare("UPDATE setting SET value = ?   WHERE setting_id = ? ");
			$query->execute(array($value,$id));	
		}
	/* end transaction */
	

	/* category */
		public function selected_category($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_category  WHERE category_id = '$id'");
			return $query->fetch();	
		}
		public function delete_category($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_category WHERE category_id = '$id'");
			$query->execute();	
		}
		public function category_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_category");
			return $query->fetchAll();	
		}
		public function add_category($POST){
			global $conn;
			$category = $POST['category'];
			
			$query = $conn->prepare("INSERT INTO tbl_category (category_name) VALUES(?)");
			$query->execute(array($category));	
		}
		public function update_category($POST){
			global $conn;
			$id = $POST['id'];
			$category = $POST['category'];
			$query = $conn->prepare("UPDATE tbl_category SET category_name = ?   WHERE category_id = ? ");
			$query->execute(array($category,$id));	
		}
  /* end category */
  
  	/* stock */
		public function stock_list($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_stock WHERE product_id = '$id' ORDER BY date_added DESC");
			return $query->fetchAll();	
		}
		public function stock_count($id){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) as item_stock FROM tbl_stock WHERE product_id = '$id' ");
			$row =  $query->fetch();	
			return $row['item_stock'];
		}
		public function add_stock($POST){
			global $conn;
			$qty = $POST['qty'];
			$product_id = $POST['product_id'];
			$date_added = date('Y-m-d');
			$query = $conn->prepare("INSERT INTO tbl_stock (qty,product_id,date_added) VALUES(?,?,?)");
			$query->execute(array($qty,$product_id,$date_added));	
		}

	/* end stock */
  
  	/* product */
		public function change_product_picture($POST){
			global $conn;
			$id = $POST['id'];
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("UPDATE tbl_product SET photo = ?   WHERE product_id = ? ");
			$query->execute(array($file,$id));
		}
		public function selected_product($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product 
			LEFT JOIN tbl_category ON tbl_product.product_id  = tbl_category.category_id  
			WHERE tbl_product.product_id = '$id'");
			return $query->fetch();	
		}
		public function delete_product($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_product WHERE product_id = '$id'");
			$query->execute();	
		}
		public function product_list($category_id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product LEFT 
			JOIN tbl_category ON tbl_product.category_id  = tbl_category.category_id  
			 WHERE tbl_product.category_id = '$category_id' ");
			return $query->fetchAll();	
		}
		public function product_list_all(){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product LEFT JOIN tbl_category ON tbl_product.category_id  = tbl_category.category_id    ");
			return $query->fetchAll();	
		}
		public function product_list_by_category($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product LEFT JOIN tbl_category ON tbl_product.category_id  = tbl_category.category_id  WHERE tbl_product.category_id = '$id'   ");
			return $query->fetchAll();	
		}
		public function add_product($POST){
			global $conn;
			$product_code = $POST['product_code'];
			$name = $POST['name'];
			$description = $POST['description'];
			$category_id = $POST['category_id'];
			$unit = $POST['unit'];
			$price = $POST['price'];
			
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			
			$query = $conn->prepare("INSERT INTO tbl_product (name,description,category_id,price,product_code,photo,unit) VALUES(?,?,?,?,?,?,?)");
			$query->execute(array($name,$description,$category_id,$price,$product_code,$file,$unit));	
		}
		public function update_product($POST){
			global $conn;
			$id = $POST['id'];
			$product_code = $POST['product_code'];
			$name = $POST['name'];
			$description = $POST['description'];
			$category_id = $POST['category_id'];
			$unit = $POST['unit'];
			$price = $POST['price'];
			$query = $conn->prepare("UPDATE tbl_product SET product_code = ?  , name = ? , description = ? , category_id = ? , price = ? , unit = ? WHERE product_id = ? ");
			$query->execute(array($product_code,$name,$description,$category_id,$price,$unit,$id));	
		}
		public function check_item_order($item_id){
			global $conn;
			$query = $conn->query("SELECT SUM(qty) AS total_qty FROM item_order   WHERE item_id = '$item_id' ");
			$row =  $query->fetch();	
			$order_item =  $row['total_qty'];
			
			$query = $conn->query("SELECT SUM(qty) AS total_qty FROM pos_details   WHERE item_id = '$item_id' ");
			$row =  $query->fetch();
			$pos_item =  $row['total_qty'];	
			return $order_item + $pos_item;
			
		}
		public function inventory_report_all($condition){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product LEFT JOIN tbl_category ON tbl_product.category_id  = tbl_category.category_id  
			WHERE tbl_product.category_id LIKE '%%' $condition
			");
			return $query->fetchAll();	
		}
		public function inventory_report_by_category($id,$condition){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_product LEFT JOIN tbl_category ON tbl_product.category_id  = tbl_category.category_id 
			WHERE tbl_product.category_id = '$id' $condition   ");
			return $query->fetchAll();	
		}
	/* end product */
	
	
		/* service */
		public function selected_service($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_service  WHERE service_id = '$id'");
			return $query->fetch();	
		}
		public function delete_service($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_service WHERE service_id = '$id'");
			$query->execute();	
		}
		public function service_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_service 
			LEFT JOIN tbl_service_category ON tbl_service.service_category_id = tbl_service_category.service_category_id");
			return $query->fetchAll();	
		}
		public function service_list_by_category($id){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_service 
			LEFT JOIN tbl_service_category ON tbl_service.service_category_id = tbl_service_category.service_category_id 
			WHERE tbl_service.service_category_id  = '$id'");
			return $query->fetchAll();	
		}
		public function add_service($POST){
			global $conn;
			$name = $POST['name'];
			$description = $POST['description'];
			$service_category_id = $POST['service_category_id'];
			$price = $POST['price'];
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("INSERT INTO tbl_service (name,description,service_category_id,price,photo) VALUES(?,?,?,?,?)");
			$query->execute(array($name,$description,$service_category_id,$price,$file));	
		}
		public function update_service($POST){
			global $conn;
			$id = $POST['id'];
			$name = $POST['name'];
			$description = $POST['description'];
			$service_category_id = $POST['service_category_id'];
			$price = $POST['price'];
			
			$query = $conn->prepare("UPDATE tbl_service SET name = ? , description = ? , service_category_id = ? , price = ?   WHERE service_id = ? ");
			$query->execute(array($name,$description,$service_category_id,$price,$id));	
		}
		public function change_service_picture($POST){
			global $conn;
			$id = $POST['id'];
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("UPDATE tbl_service SET photo = ?   WHERE service_id = ? ");
			$query->execute(array($file,$id));
		}
    /* end service */
	
	
	/* units */
		public function selected_units($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_units  WHERE units_id = '$id'");
			return $query->fetch();	
		}
		public function delete_units($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_units WHERE units_id = '$id'");
			$query->execute();	
		}
		public function units_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_units");
			return $query->fetchAll();	
		}
		public function add_units($POST){
			global $conn;
			$units = $POST['units'];
			$query = $conn->prepare("INSERT INTO tbl_units (units) VALUES(?)");
			$query->execute(array($units));	
		}
		public function update_units($POST){
			global $conn;
			$id = $POST['id'];
			$units = $POST['units'];
			$query = $conn->prepare("UPDATE tbl_units SET units = ?   WHERE units_id = ? ");
			$query->execute(array($units,$id));	
		}
    /* end units */
	
	/* position */
		public function selected_position($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_position  WHERE position_id = '$id'");
			return $query->fetch();	
		}
		public function delete_position($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_position WHERE position_id = '$id'");
			$query->execute();	
		}
		public function position_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_position");
			return $query->fetchAll();	
		}
		public function add_position($POST){
			global $conn;
			$position = $POST['position'];
			$query = $conn->prepare("INSERT INTO tbl_position (position) VALUES(?)");
			$query->execute(array($position));	
		}
		public function update_position($POST){
			global $conn;
			$id = $POST['id'];
			$position = $POST['position'];
			$query = $conn->prepare("UPDATE tbl_position SET position = ?   WHERE position_id = ? ");
			$query->execute(array($position,$id));	
		}
    /* end position */
	
	/* service category */
		public function selected_service_category($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_service_category  WHERE service_category_id = '$id'");
			return $query->fetch();	
		}
		public function delete_service_category($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_service_category WHERE service_category_id = '$id'");
			$query->execute();	
		}
		public function service_category_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_service_category");
			return $query->fetchAll();	
		}
		public function add_service_category($POST){
			global $conn;
			$service_category = $POST['service_category'];
			
			$query = $conn->prepare("INSERT INTO tbl_service_category (service_category) VALUES(?)");
			$query->execute(array($service_category));	
		}
		public function update_service_category($POST){
			global $conn;
			$id = $POST['id'];
			$service_category = $POST['service_category'];
			$query = $conn->prepare("UPDATE tbl_service_category SET service_category = ?   WHERE service_category_id = ? ");
			$query->execute(array($service_category,$id));	
		}
	/* end service category */
	
	
	/* staff */
		public function selected_staff($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_staff  WHERE staff_id = '$id'");
			return $query->fetch();	
		}
		public function delete_staff($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_staff WHERE staff_id = '$id'");
			$query->execute();	
		}
		public function staff_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_staff 
			LEFT JOIN tbl_position ON tbl_staff.position_id = tbl_position.position_id
			");
			return $query->fetchAll();	
		}
		public function add_staff($POST){
			global $conn;
			$name = $POST['name'];
			$gender = $POST['gender'];
			$address = $POST['address'];
			$mobile_no = $POST['mobile_no'];
			$position_id = $POST['position_id'];
			
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("INSERT INTO tbl_staff (name,gender,address,mobile_no,position_id,photo) VALUES(?,?,?,?,?,?)");
			$query->execute(array($name,$gender,$address,$mobile_no,$position_id,$file));	
		}
		public function update_staff($POST){
			global $conn;
			$id = $POST['id'];
			$name = $POST['name'];
			$gender = $POST['gender'];
			$address = $POST['address'];
			$mobile_no = $POST['mobile_no'];
			$position_id = $POST['position_id'];
			
			$query = $conn->prepare("UPDATE tbl_staff SET name = ? , gender = ? , address = ? , mobile_no = ?  , position_id = ?   WHERE staff_id = ? ");
			$query->execute(array($name,$gender,$address,$mobile_no,$position_id,$id));	
		}
		public function change_staff_picture($POST){
			global $conn;
			$id = $POST['id'];
			$rd2 = mt_rand(1000, 9999);
			$filename = basename($_FILES['file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$file = $rd2. "_" .$filename;
			(move_uploaded_file($_FILES['file']['tmp_name'],'../uploads/'.$file));
			
			$query = $conn->prepare("UPDATE tbl_staff SET photo = ?   WHERE staff_id = ? ");
			$query->execute(array($file,$id));
		}
  /* end staff */
  
  	/* order status */
		public function selected_order_status($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_order_status  WHERE order_status_id = '$id'");
			return $query->fetch();	
		}
		public function delete_order_status($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_order_status WHERE order_status_id = '$id'");
			$query->execute();	
		}
		public function order_status_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_order_status");
			return $query->fetchAll();	
		}
		public function add_order_status($POST){
			global $conn;
			$order_status = $POST['order_status'];
			$query = $conn->prepare("INSERT INTO tbl_order_status (order_status) VALUES(?)");
			$query->execute(array($order_status));	
		}
		public function update_order_status($POST){
			global $conn;
			$id = $POST['id'];
			$order_status = $POST['order_status'];
			$query = $conn->prepare("UPDATE tbl_order_status SET order_status = ?   WHERE order_status_id = ? ");
			$query->execute(array($order_status,$id));	
		}
    /* end order status */
	
	
	  	/* res status */
		public function selected_res_status($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_res_status  WHERE res_status_id = '$id'");
			return $query->fetch();	
		}
		public function delete_res_status($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_res_status WHERE res_status_id = '$id'");
			$query->execute();	
		}
		public function res_status_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_res_status");
			return $query->fetchAll();	
		}
		public function add_res_status($POST){
			global $conn;
			$res_status = $POST['res_status'];
			$query = $conn->prepare("INSERT INTO tbl_res_status (res_status) VALUES(?)");
			$query->execute(array($res_status));	
		}
		public function update_res_status($POST){
			global $conn;
			$id = $POST['id'];
			$res_status = $POST['res_status'];
			$query = $conn->prepare("UPDATE tbl_res_status SET res_status = ?   WHERE res_status_id = ? ");
			$query->execute(array($res_status,$id));	
		}
    /* end res status */
	
	
	 /* message */
		public function message_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_message ORDER BY message_date DESC");
			return $query->fetchAll();	
		}
		public function add_message($POST){
			global $conn;
			$name = $POST['name'];
			$email = $POST['email'];
			$content = $POST['content'];
			$message_date = date('Y-m-d');
			$query = $conn->prepare("INSERT INTO tbl_message (name,email,content,message_date) VALUES(?,?,?,?)");
			$query->execute(array($name,$email,$content,$message_date));	
		}
		public function delete_message($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_message WHERE message_id = '$id'");
			$query->execute();	
		}
    /* end message */
	
	/* year */
		public function selected_year($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_year  WHERE year_id = '$id'");
			return $query->fetch();	
		}
		public function delete_year($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_year  WHERE year_id = '$id'");
			$query->execute();	
		}
		public function year_list(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_year ORDER BY year DESC");
			return $query->fetchAll();	
		}
		public function add_year($POST){
			global $conn;
			$year = $POST['year'];
			$query = $conn->prepare("INSERT INTO tbl_year (year) VALUES(?)");
			$query->execute(array($year));	
		}
		public function update_year($POST){
			global $conn;
			$id = $POST['id'];
			$year = $POST['year'];
			$query = $conn->prepare("UPDATE tbl_year SET year = ?   WHERE year_id = ? ");
			$query->execute(array($year,$id));	
		}
    /* end year */
	
	
}
$system = new system_class();
?>