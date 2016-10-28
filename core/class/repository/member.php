<?php 
class MemberRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_member.Id as Id FROM tbl_member
			LEFT JOIN tbl_member_type on tbl_member_type.Id = tbl_member.MemberTypeId
			WHERE tbl_member.Id = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		public function GetAttendance($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_event_details 
			LEFT JOIN tbl_events on tbl_event_details.EventId = tbl_events.Id
			WHERE tbl_event_details.MemberId = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		public function GetByBarcode($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_member.Id as Id FROM tbl_member  
			LEFT JOIN tbl_member_type on tbl_member_type.Id = tbl_member.MemberTypeId
			WHERE Barcode = '$id'");
			$count = $query->rowcount();
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		public function GetByIdNumber($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member WHERE IdNumber = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize,$type){
			global $conn;
	
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$where = "";
			if($searchText != ''){
				$where = "And (
				firstname  LIKE '%$searchText%' OR 
				middlename  LIKE '%$searchText%' OR 
				lastname  LIKE '%$searchText%' OR 
				code  LIKE '%$searchText%' OR 
				year  LIKE '%$searchText%' OR
				section  LIKE '%$searchText%'
				)";
			}
				$where .= "AND MemberTypeId = '$type'";
			
			$query = $conn->query("SELECT *,tbl_member.Id as Id FROM  tbl_member 
			LEFT JOIN tbl_course on tbl_course.Id = tbl_member.CourseId	
			LEFT JOIN tbl_section on tbl_section.Id = tbl_member.SectionId	
			LEFT JOIN tbl_course_year on tbl_course_year.Id = tbl_member.CourseYearId	
			WHERE 1 = 1 $where   $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_member WHERE MemberTypeId = '$type'")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("
				INSERT INTO 
					   tbl_member 
					  (firstname,lastname,middlename,gender,address,mobile_no,email,date_registered,MemberTypeId,CourseId,CourseYearId,SectionId,IdNumber,Barcode) 
				VALUES(:firstname,:lastname,:middlename,:gender,:address,:mobile_no,:email,:date_registered,:MemberTypeId,:CourseId,:CourseYearId,:SectionId,:IdNumber,:Barcode)
				");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("
				UPDATE
					   tbl_member SET
					   firstname = :firstname,
					   lastname = :lastname,
					   middlename = :middlename,
					   gender = :gender,
					   address = :address,
					   mobile_no = :mobile_no,
					   email = :email,
					   MemberTypeId = :MemberTypeId,
					   CourseId = :CourseId,
					   CourseYearId = :CourseYearId,
					   SectionId = :SectionId,
					   IdNumber = :IdNumber,
					   DateTransfer = :DateTransfer,
					   Transfer = :Transfer,
					   Barcode = :Barcode
					   WHERE Id = :Id
				");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->firstname = !isset($POST->firstname) ? '' : $POST->firstname;
			$POST->lastname = !isset($POST->lastname) ? '' : $POST->lastname;
			$POST->middlename = !isset($POST->middlename) ? '' : $POST->middlename;
			$POST->gender = !isset($POST->gender) ? '' : $POST->gender;
			$POST->email = !isset($POST->email) ? '' : $POST->email;
			$POST->mobile_no = !isset($POST->mobile_no) ? '' : $POST->mobile_no;
			$POST->address = !isset($POST->address) ? '' : $POST->address;
			$POST->CourseId = !isset($POST->CourseId) ? '' : $POST->CourseId;
			$POST->CourseYearId = !isset($POST->CourseYearId) ? '' : $POST->CourseYearId;
			$POST->SectionId = !isset($POST->SectionId) ? '' : $POST->SectionId;
			$POST->MemberTypeId = !isset($POST->MemberTypeId) ? '' : $POST->MemberTypeId;
			$POST->IdNumber = !isset($POST->IdNumber) ? '' : $POST->IdNumber;
			$POST->Transfer = !isset($POST->Transfer) ? null : $POST->Transfer;
			$POST->DateTransfer = !isset($POST->DateTransfer) ? '' : $POST->DateTransfer;
			$POST->Barcode = !isset($POST->Barcode) ? '' : $POST->Barcode;
			$POST->date_registered = date('Y-m-d');

			return $POST;
		}
		public function Save($POST){
			global $conn;

			if($POST->Id == 0){
				$query = $this->Create();
				$query->bindParam(':date_registered',$POST->date_registered);
			}else{
				$query = $this->Update();
				$query->bindParam(':Id', $POST->Id);
			}
			

		

			$query->bindParam(':firstname', $POST->firstname);
			$query->bindParam(':lastname', $POST->lastname);
			$query->bindParam(':middlename', $POST->middlename);
			$query->bindParam(':gender', $POST->gender);
			$query->bindParam(':email', $POST->email );
			$query->bindParam(':mobile_no',  $POST->mobile_no );
			$query->bindParam(':address', $POST->address );
			$query->bindParam(':CourseId', $POST->CourseId );
			$query->bindParam(':CourseYearId', $POST->CourseYearId );
			$query->bindParam(':SectionId', $POST->SectionId );
			$query->bindParam(':MemberTypeId', $POST->MemberTypeId );
			$query->bindParam(':IdNumber', $POST->IdNumber );
			$query->bindParam(':Barcode', $POST->Barcode);

			if($POST->Transfer != null){
				 $query->bindParam(':Transfer',$POST->Transfer);
				 $query->bindParam(':DateTransfer',$POST->DateTransfer);
			} 
			
			
			
			$query->execute();	
			
		}
		public function SignUp($POST){
			$this->Save($POST);		
		}
		public function ChangePassword(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$Id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$cpassword =  $POST->cpassword;
			$newpassword =  $POST->newpassword;
			
			$count = $conn->query("SELECT * FROM tbl_member WHERE  password = '$cpassword' AND Id = '$Id' ")->rowcount();

			if($count > 0){
				$query = $conn->prepare("UPDATE tbl_member SET password = ? WHERE Id = ? ");
				$query->execute(array($newpassword,$Id));
			}else{
				 return 'cpFalse';
			}

			
		}
}
$GLOBALS['MemberRepo'] = new MemberRepository();
?>