<?php 
$slim_app->get('/year/:id',function($id){
	$result = $GLOBALS['YearRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/year',function(){
	$result = $GLOBALS['YearRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/year/:id',function($id){
	$GLOBALS['YearRepo']->Delete($id);
});
$slim_app->post('/year',function(){
	$GLOBALS['YearRepo']->Save();
});
?>