<?php 
$slim_app->get('/semester/:id',function($id){
	$result = $GLOBALS['SemesterRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/semester',function(){
	$result = $GLOBALS['SemesterRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/semester/:id',function($id){
	$GLOBALS['SemesterRepo']->Delete($id);
});
$slim_app->post('/semester',function(){
	$GLOBALS['SemesterRepo']->Save();
});
?>