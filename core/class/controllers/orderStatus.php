<?php 
$slim_app->get('/orderStatus/:id',function($id){
	$result = $GLOBALS['OrderStatusRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/orderStatus',function(){
	$result = $GLOBALS['OrderStatusRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/orderStatus/:id',function($id){
	$GLOBALS['OrderStatusRepo']->Delete($id);
});
$slim_app->post('/orderStatus',function(){
	$GLOBALS['OrderStatusRepo']->Save();
});
?>