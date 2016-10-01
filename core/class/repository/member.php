<?php 
class MemberRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
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
			
			$query = $conn->query("SELECT * FROM  tbl_member WHERE firstname LIKE '%$searchText%' AND MemberTypeId = '$type'  $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_member")->rowcount();
			
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
					  (firstname,lastname,middlename,gender,address,mobile_no,username,password,email,date_registered,MemberTypeId,CourseId,CourseYearId,SectionId,IdNumber) 
				VALUES(:firstname,:lastname,:middlename,:gender,:address,:mobile_no,:username,:password,:email,:date_registered,:MemberTypeId,:CourseId,:CourseYearId,:SectionId,:IdNumber)
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
					   username = :username,
					   password = :password,
					   email = :email,
					   MemberTypeId = :MemberTypeId,
					   CourseId = :CourseId,
					   CourseYearId = :CourseYearId,
					   SectionId = :SectionId,
					   IdNumber = :IdNumber,
					   DateTransfer = :DateTransfer,
					   Transfer = :Transfer
					   WHERE Id = :Id
				");
			return $query;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
		
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			$query->bindParam(':firstname', $POST->firstname);
			$query->bindParam(':lastname', $POST->lastname);
			$query->bindParam(':middlename', $POST->middlename);
			$query->bindParam(':gender', $POST->gender);
			$query->bindParam(':email', !isset($POST->email) ? '' : $POST->email );
			$query->bindParam(':mobile_no', !isset($POST->mobile_no) ? '' : $POST->mobile_no );
			$query->bindParam(':address', !isset($POST->address) ? '' : $POST->address );
			$query->bindParam(':username', !isset($POST->username) ? '' : $POST->username );
			$query->bindParam(':password', !isset($POST->password) ? '' : $POST->password );
			$query->bindParam(':CourseId', !isset($POST->CourseId) ? '' : $POST->CourseId );
			$query->bindParam(':CourseYearId', !isset($POST->CourseYearId) ? '' : $POST->CourseYearId );
			$query->bindParam(':SectionId', !isset($POST->SectionId) ? '' : $POST->SectionId );
			$query->bindParam(':MemberTypeId', !isset($POST->MemberTypeId) ? '' : $POST->MemberTypeId );
			$query->bindParam(':IdNumber', !isset($POST->IdNumber) ? '' : $POST->IdNumber );
			if($Id == 0){ $query->bindParam(':date_registered', date('Y-m-d')); }
			
			$Transfer = !isset($POST->Transfer) ? 0 : $POST->Transfer;
			$Transfer != 0 ? $query->bindParam(':Transfer',$Transfer) : '' ;
			$Transfer != 0 ? $query->bindParam(':DateTransfer',date('Y-m-d')) : '';

			
			
			
			$query->execute();	
			
		}
		public function SignUp(){
			$this->Save();		
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