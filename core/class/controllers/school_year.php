<?php 
$slim_app->get('/schoolYear/:id',function($id){
	$SchoolYearRepo = new SchoolYearRepository();
	$result = $SchoolYearRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/schoolYear',function(){
	$SchoolYearRepo = new SchoolYearRepository();
	$result = $SchoolYearRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/schoolYear/:id',function($id){
	$SchoolYearRepo = new SchoolYearRepository();
	$SchoolYearRepo->Delete($id);
});
$slim_app->post('/schoolYear',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$SchoolYearRepo = new SchoolYearRepository();
	$SchoolYearRepo->Save($SchoolYearRepo->Transform($POST));
});
$slim_app->post('/schoolYear/saveall',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$SchoolYearRepo = new SchoolYearRepository();
	foreach($POST as $row){
		$SchoolYearRepo->Save($SchoolYearRepo->Transform($row));
	}	
});
?>