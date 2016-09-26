<?php 
$slim_app->get('/department/:id',function($id){
	$result = $GLOBALS['DepartmentRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/department',function(){
	$result = $GLOBALS['DepartmentRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/department/:id',function($id){
	$GLOBALS['DepartmentRepo']->Delete($id);
});
$slim_app->post('/department',function(){
	$GLOBALS['DepartmentRepo']->Save();
});
?>