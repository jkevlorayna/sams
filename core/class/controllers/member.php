<?php 
$slim_app->get('/member/:id',function($id){
	$CourseRepo = new CourseRepository();
	$CourseYearRepo = new CourseYearRepository();
	$MemberRepo = new MemberRepository();
	$SectionRepo = new SectionRepository();
	
	$result = $MemberRepo->Get($id);
	$result->Course =  $CourseRepo->Get($result->CourseId);
	$result->CourseYear =  $CourseYearRepo->Get($result->CourseYearId);
	$result->Section =  $SectionRepo->Get($result->SectionId);
	echo json_encode($result);
});
$slim_app->get('/member/attendance/:id',function($id){
	$MemberRepo = new MemberRepository();

	$result = $MemberRepo->GetAttendance($id,$_GET['Semester'],$_GET['SchoolYear']);

	echo json_encode($result);
});
$slim_app->get('/member',function(){
	$result = $GLOBALS['MemberRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['type'],$_GET['CourseId'],$_GET['CourseYearId'],$_GET['SectionId']);
	echo json_encode($result);
});
$slim_app->delete('/member/:id',function($id){
	 $GLOBALS['MemberRepo']->Delete($id);
});
$slim_app->post('/member',function(){
		$MemberRepo = new MemberRepository();
	
		$request = \Slim\Slim::getInstance()->request();
		$POST = json_decode($request->getBody());
		$MemberRepo->Save($MemberRepo->Transform($POST));
});
$slim_app->post('/signup',function(){
		$MemberRepo = new MemberRepository();
		
		$request = \Slim\Slim::getInstance()->request();
		$POST = json_decode($request->getBody());
		
		

		$p = $MemberRepo->Transform($POST);
		if($p->Id == 0){
			if(is_object($MemberRepo->GetByIdNumber($p->IdNumber))){
				echo 'exist';	
			}else{
				echo json_encode($MemberRepo->SignUp($p));				
			}
		}else{
				echo json_encode($MemberRepo->SignUp($p));
		}
		
});

$slim_app->post('/member/changepassword',function(){
	 $GLOBALS['MemberRepo']->ChangePassword();
});

$slim_app->post('/member/upload/:Id',function($Id){
	$MemberRepo = new MemberRepository();
	$result = $MemberRepo->Get($Id);

		if ( !empty( $_FILES ) ) {
			foreach($_FILES as $row){
				$tempPath = $row[ 'tmp_name' ];
				$rd2 = mt_rand(1000, 9999);
				$filename = $rd2. "_" .$row[ 'name' ];
				$uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '../uploads/' . DIRECTORY_SEPARATOR . $filename;
				
				
				$result->ImageUrl = $filename;
				$MemberRepo->SignUp($result);
				$location = move_uploaded_file( $tempPath, $uploadPath );
				$answer = array( 'answer' => 'File transfer completed' );
				$json = json_encode( $answer );
			
				echo $json;
			}
		} else {
		
			echo 'No files';
		}
});


		
?>