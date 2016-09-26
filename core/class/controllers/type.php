<?php 
$slim_app->get('/type/:id',function($id){
	$result = $GLOBALS['TypeRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/type',function(){
	$result = $GLOBALS['TypeRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/type/:id',function($id){
	 $GLOBALS['TypeRepo']->Delete($id);
});
$slim_app->post('/type',function(){
	$GLOBALS['TypeRepo']->Save();
});
?>