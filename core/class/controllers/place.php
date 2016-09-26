<?php 
$slim_app->get('/place/:id',function($id){
	$result = $GLOBALS['PlaceRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/place',function(){
	$result = $GLOBALS['PlaceRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/place/:id',function($id){
	$GLOBALS['PlaceRepo']->Delete($id);
});
$slim_app->post('/place',function(){
	$GLOBALS['PlaceRepo']->Save();
});
?>