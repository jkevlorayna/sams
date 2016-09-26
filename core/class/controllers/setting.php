<?php 
$slim_app->get('/setting/:id',function($id){
	$result = $GLOBALS['SettingRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/setting',function(){
	$result =  $GLOBALS['SettingRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/setting/:id',function($id){
	$GLOBALS['SettingRepo']->Delete($id);
});
$slim_app->post('/setting',function(){
	$GLOBALS['SettingRepo']->Save();
});
?>