<?php 
$slim_app->get('/schoolYear/:id',function($id){
	$result = $GLOBALS['SchoolYearRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/schoolYear',function(){
	$result = $GLOBALS['SchoolYearRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/schoolYear/:id',function($id){
	$GLOBALS['SchoolYearRepo']->Delete($id);
});
$slim_app->post('/schoolYear',function(){
	$GLOBALS['SchoolYearRepo']->Save();
});
?>