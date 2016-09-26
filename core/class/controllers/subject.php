<?php 
$slim_app->get('/subject/:id',function($id){
	$result = $GLOBALS['SubjectRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/subject',function(){
	$result = $GLOBALS['SubjectRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/subject/:id',function($id){
	$GLOBALS['SubjectRepo']->Delete($id);
});
$slim_app->post('/subject',function(){
	$GLOBALS['SubjectRepo']->Save();
});
?>