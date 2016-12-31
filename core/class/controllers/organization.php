<?php 
$slim_app->get('/organization/:id',function($id){
	$OrganizationRepo = new OrganizationRepository();
	$result = $OrganizationRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/organization',function(){
	$OrganizationRepo = new OrganizationRepository();
	$result = $OrganizationRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/organization/:id',function($id){
	$OrganizationRepo = new OrganizationRepository();
	$OrganizationRepo->Delete($id);
	$OrganizationRepo->DeleteByCourse($id);
});
$slim_app->post('/organization',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$OrganizationRepo = new OrganizationRepository();
	$OrganizationRepo->Save($OrganizationRepo->Transform($POST));
});
?>