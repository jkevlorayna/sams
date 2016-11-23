<?php 
$slim_app->get('/semester/:id',function($id){
	$SemesterRepo = new SemesterRepository();
	$result = $SemesterRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/semester',function(){
	$SemesterRepo = new SemesterRepository();
	$result = $SemesterRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/semester/:id',function($id){
	$SemesterRepo = new SemesterRepository();
	$SemesterRepo->Delete($id);
});
$slim_app->post('/semester',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$SemesterRepo = new SemesterRepository();
	$SemesterRepo->Save($SemesterRepo->Transform($POST));
});
$slim_app->post('/semester/saveall',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$SemesterRepo = new SemesterRepository();
	foreach($POST as $row){
		$SemesterRepo->Save($SemesterRepo->Transform($row));
	}	
});
?>