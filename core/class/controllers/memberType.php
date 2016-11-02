<?php 
$slim_app->get('/memberType/:id',function($id){
	$MemberTypeRepo = new MemberTypeRepository();
	$result = $MemberTypeRepo->Get($id);
	$result->EnableAdd = $result->EnableAdd ==  1 ? TRUE : FALSE;
	$result->EnableBarcode = $result->EnableBarcode ==  1 ? TRUE : FALSE;
	$result->Movable = $result->Movable ==  1 ? TRUE : FALSE;

	echo json_encode($result);
});
$slim_app->get('/memberType',function(){
	$MemberTypeRepo = new MemberTypeRepository();
	$result = $MemberTypeRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/memberType/:id',function($id){
	$MemberTypeRepo = new MemberTypeRepository();
	 $MemberTypeRepo->Delete($id);
});
$slim_app->post('/memberType',function(){
	$MemberTypeRepo = new MemberTypeRepository();
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$MemberTypeRepo->Save($MemberTypeRepo->Transform($POST));
});
?>