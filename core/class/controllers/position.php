<?php 
$slim_app->get('/position/:id',function($id){
	$result = $GLOBALS['PositionRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/position',function(){
	$result = $GLOBALS['PositionRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/position/:id',function($id){
	 $GLOBALS['PositionRepo']->Delete($id);
});
$slim_app->post('/position',function(){
	 $GLOBALS['PositionRepo']->Save();
});
?>