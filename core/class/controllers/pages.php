<?php 
$slim_app->get('/pages/:id',function($id){
	$result = $GLOBALS['PagesRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/pages',function(){
	$result = $GLOBALS['PagesRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/pages/:id',function($id){
	$GLOBALS['PagesRepo']->Delete($id);
});
$slim_app->post('/pages',function(){
	$GLOBALS['PagesRepo']->Save();
});
?>