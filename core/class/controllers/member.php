<?php 
$slim_app->get('/member/:id',function($id){
	$CourseRepo = new CourseRepository();
	$CourseYearRepo = new CourseYearRepository();
	
	$result = $GLOBALS['MemberRepo']->Get($id);
	$result['Course'] =  $CourseRepo->Get($result['CourseId']);
	$result['CourseYear'] =  $CourseYearRepo->Get($result['CourseYearId']);
	$result['Section'] =  $GLOBALS['SectionRepo']->Get($result['SectionId']);
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
	 $GLOBALS['MemberRepo']->Save();
});
$slim_app->post('/signup',function(){
	 $GLOBALS['MemberRepo']->SignUp();
});
$slim_app->post('/member/changepassword',function(){
	 $GLOBALS['MemberRepo']->ChangePassword();
});
?>