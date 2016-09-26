<?php 
$slim_app->get('/course-year/:id',function($id){
	$CourseYearRepo = new CourseYearRepository();
	$result = $CourseYearRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/course-year/:CourseId/list',function($CourseId){
	$CourseYearRepo = new CourseYearRepository();
	$result =  $CourseYearRepo->DataList($CourseId,$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/course-year/:id',function($id){
	$CourseYearRepo = new CourseYearRepository();
	$CourseYearRepo->Delete($id);
});
$slim_app->post('/course-year',function(){
	$CourseYearRepo = new CourseYearRepository();
	$CourseYearRepo->Save();
});
?>