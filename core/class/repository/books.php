<?php 
class BooksRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_books.Id As Id FROM tbl_books 
			LEFT JOIN tbl_subject ON  tbl_subject.Id = tbl_books.SubjectId
			LEFT JOIN tbl_category ON  tbl_category.Id = tbl_books.CategoryId
			WHERE tbl_books.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_books  WHERE Id = '$id'");
			$query->execute();	
		}
		 public function DataList($searchText,$pageNo,$pageSize,$status,$archive){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					
					$status = $status == 'all' ? '' : $status;	
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT *,tbl_books.Id As Id
			FROM  tbl_books 
			LEFT JOIN tbl_category ON tbl_books.CategoryId = tbl_category.Id
			LEFT JOIN tbl_subject ON tbl_books.SubjectId = tbl_subject.Id
			WHERE title LIKE '%$searchText%' AND status LIKE '%$status%' AND archive = '$archive' $limitCondition ");
			
			$count  = $searchText != '' ? $query->rowcount() :  $conn->query("SELECT * FROM  tbl_books WHERE archive = '$archive'")->rowcount();


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
			$title = (!isset($POST->title)) ? '' : $POST->title;
			$author = (!isset($POST->author)) ? '' : $POST->author;
			$SubjectId = (!isset($POST->SubjectId)) ? 0 : $POST->SubjectId;
			$CategoryId = (!isset($POST->CategoryId)) ? 0 : $POST->CategoryId;
			$copies = (!isset($POST->copies)) ? 0 : $POST->copies;
			$publisher_name = (!isset($POST->publisher_name)) ? '' : $POST->publisher_name;
			$isbn_no = (!isset($POST->isbn_no)) ? 0 : $POST->isbn_no;
			$copyright_year = (!isset($POST->copyright_year)) ? 0 : $POST->copyright_year;
			$status = (!isset($POST->status)) ? '' : $POST->status;
			$archive = (!isset($POST->archive)) ? '' : $POST->archive;
			
		
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_books (title,author,SubjectId,CategoryId,copies,publisher_name,isbn_no,copyright_year,status,archive) VALUES(?,?,?,?,?,?,?,?,?,?)");
				$query->execute(array($title,$author,$SubjectId,$CategoryId,$copies,$publisher_name,$isbn_no,$copyright_year,$status,$archive));	
			}else{
				$query = $conn->prepare("UPDATE tbl_books SET title = ? , author = ? , SubjectId = ? , CategoryId = ? , copies = ? , publisher_name = ?
				,isbn_no = ? , copyright_year = ? , status = ? , archive = ? WHERE Id = ? ");
				$query->execute(array($title,$author,$SubjectId,$CategoryId,$copies,$publisher_name,$isbn_no,$copyright_year,$status,$archive,$id));	
			}

		}

		
		public function Borrow(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$MemberId = (!isset($POST->MemberId)) ? 0 : $POST->MemberId;
			$date_borrow =  date('Y-m-d');
			$date_return =  date('Y-m-d');
			$remarks = (!isset($POST->remarks)) ? 0 : $POST->remarks;
			$OrNumber = (!isset($POST->OrNumber)) ? 0 : $POST->OrNumber;

			$query = $conn->prepare("INSERT INTO tbl_borrow (MemberId,date_borrow,date_return,remarks,OrNumber) VALUES(?,?,?,?,?)");
			$query->execute(array($MemberId,$date_borrow,$date_return,$remarks,$OrNumber));	
			$BorrowId = $conn->lastInsertId();
			
			foreach($POST->borrowList as $row){
				$query = $conn->prepare("INSERT INTO tbl_borrow_details (BorrowId,BookId) VALUES(?,?)");
				$query->execute(array($BorrowId,$row->Id));	
				
			}
		}
		public function BorrowList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 

			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_borrow.Id As Id FROM  tbl_borrow $limitCondition ");
			$count  = $searchText != '' ? $query->rowcount() :  $conn->query("SELECT * FROM  tbl_borrow")->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function GetBorrow($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_borrow WHERE Id = $id ");
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		public function BorrowDetails($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_borrow_details 
			LEFT JOIN tbl_books ON tbl_borrow_details.BookId = tbl_books.Id
			WHERE BorrowID = $id ");
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
}
$GLOBALS['BooksRepo'] = new BooksRepository();		



?>