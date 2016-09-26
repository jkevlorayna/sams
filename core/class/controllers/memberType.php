<?php 
$slim_app->get('/memberType/:id',function($id){
	$result = $GLOBALS['MemberTypeRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/memberType',function(){
	$result = $GLOBALS['MemberTypeRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/memberType/:id',function($id){
	 $GLOBALS['MemberTypeRepo']->Delete($id);
});
$slim_app->post('/memberType',function(){
	 $GLOBALS['MemberTypeRepo']->Save();
});
?>