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
$slim_app->get('/member',function(){
	$result = $GLOBALS['MemberRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['type']);
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
				$MemberRepo->SignUp($p);	
			}
		}else{
			$MemberRepo->SignUp($p);
		}
		
});
$slim_app->post('/member/changepassword',function(){
	 $GLOBALS['MemberRepo']->ChangePassword();
});
?>