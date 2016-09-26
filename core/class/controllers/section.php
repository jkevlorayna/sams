<?php 
$slim_app->get('/Section/:id',function($id){
	$result = $GLOBALS['SectionRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/Section',function(){
	$result = $GLOBALS['SectionRepo']->DataList($_GET['CourseYearId'],$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/Section/:id',function($id){
	$GLOBALS['SectionRepo']->Delete($id);
});
$slim_app->post('/Section',function(){
	$GLOBALS['SectionRepo']->Save();
});
?>