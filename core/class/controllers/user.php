<?php 
// user
$slim_app->get('/user/:id',function($id){
	$UserRepo = new UserRepository();
	$result = $UserRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/user',function(){
	$UserRepo = new UserRepository();
	$result = $UserRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/user/:id',function($id){
	$UserRepo = new UserRepository();
	$UserRepo->Delete($id);
});
$slim_app->post('/user',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$UserRepo = new UserRepository();
	$UserRepo->Save($UserRepo->Transform($POST));
});

// user type
$slim_app->get('/userType/:id',function($id){
	$UserTypeRepo = new UserTypeRepository();
	$result =  $UserTypeRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/userType',function(){
	$UserTypeRepo = new UserTypeRepository();
	$result =  $UserTypeRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/userType/:id',function($id){
	$UserTypeRepo = new UserTypeRepository();
	 $UserTypeRepo->Delete($id);
});
$slim_app->post('/userType',function(){
	$UserTypeRepo = new UserTypeRepository();
	 $UserTypeRepo->Save();
});

// user role
$slim_app->get('/roles/:id',function($id){
	$UserRoleRepo =  new UserRoleRepository();
	$result =  $UserRoleRepo->RoleList();

	foreach($result['Results'] as $row){
		$UserRole = $UserRoleRepo->DataList($id,$row->Id);
		
		if(is_object($UserRole)){
			$row->UserRole = $UserRole;
			$row->UserRole->AllowView = $row->UserRole->AllowView ==  1 ? TRUE : FALSE;
			$row->UserRole->AllowAdd = $row->UserRole->AllowAdd ==  1 ? TRUE : FALSE;
			$row->UserRole->AllowEdit = $row->UserRole->AllowEdit ==  1 ? TRUE : FALSE;
			$row->UserRole->AllowDelete = $row->UserRole->AllowDelete ==  1 ? TRUE : FALSE;
		}else{
			$row->UserRole = new stdClass;
		}
	}

	echo json_encode($result);
});
$slim_app->get('/userRole/UserRoles/:Id',function($Id){
	$UserRoleRepo =  new UserRoleRepository();
	$result =  $UserRoleRepo->UserRoles($Id);
	
	echo json_encode($result);
});
$slim_app->get('/userRole',function(){
	$UserRoleRepo =  new UserRoleRepository();
	$result =  $UserRoleRepo->DataList();
	echo json_encode($result);
});
$slim_app->get('/userRole/:id',function($id){
	$UserRoleRepo =  new UserRoleRepository();
	$result =  $UserRoleRepo->Get($id);
	echo json_encode($result);
});
$slim_app->delete('/userRole/:id',function($id){
	$UserRoleRepo =  new UserRoleRepository();
	$UserRoleRepo->Delete($id);
});
$slim_app->post('/userRole',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$UserRoleRepo =  new UserRoleRepository();

	foreach($POST as $row){
		$r = $UserRoleRepo->Transform($row->UserRole);
		$UserRoleRepo->Save($r);
	}
});


?>