<?php 
$slim_app->get('/course/:id',function($id){
	$CourseRepo = new CourseRepository();
	$result = $CourseRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/course',function(){
	$CourseRepo = new CourseRepository();
	$result = $CourseRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/course/:id',function($id){
	$CourseRepo = new CourseRepository();
	$CourseRepo->Delete($id);
	$CourseRepo->DeleteByCourse($id);
});
$slim_app->post('/course',function(){
	$CourseRepo = new CourseRepository();
	$$CourseRepo->Save();
});
?>