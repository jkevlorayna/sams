<?php 
$slim_app->get('/units/:id',function($id){
	echo $GLOBALS['UnitRepo']->Get($id);
});
$slim_app->get('/units',function(){
	echo $GLOBALS['UnitRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
});
$slim_app->delete('/units/:id',function($id){
	echo $GLOBALS['UnitRepo']->Delete($id);
});
$slim_app->post('/units',function(){
	echo $GLOBALS['UnitRepo']->Save();
});
?>