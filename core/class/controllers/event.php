<?php 
$slim_app->get('/event/:id',function($id){
	$EventRepo = new EventRepository();
	$result = $EventRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/event',function(){
	$EventRepo = new EventRepository();
	$result = $EventRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['Semester'],$_GET['SchoolYear']);
	echo json_encode($result);
});
$slim_app->delete('/event/:id',function($id){
	$EventRepo = new EventRepository();
	$EventRepo->Delete($id);
});
$slim_app->post('/event',function(){
	$EventRepo = new EventRepository();
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
			
	$EventRepo->Save($EventRepo->Transform($POST));
});
?>