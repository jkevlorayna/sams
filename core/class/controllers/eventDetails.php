<?php 
$slim_app->get('/event/details/:id',function($id){
	$EventRepo = new EventDetailsRepository();
	$result = $EventRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/event/details',function(){
	$EventRepo = new EventDetailsRepository();
	$result = $EventRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/event/details/:id',function($id){
	$EventRepo = new EventDetailsRepository();
	$EventRepo->Delete($id);
});
$slim_app->post('/event/details',function(){
	$EventRepo = new EventDetailsRepository();
	
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());	
	$EventRepo->Save($POST);
});
?>