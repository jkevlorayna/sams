<?php 
// user
$slim_app->get('/user/:id',function($id){
	$result = $GLOBALS['UserRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/user',function(){
	$result = $GLOBALS['UserRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/user/:id',function($id){
	$GLOBALS['UserRepo']->Delete($id);
});
$slim_app->post('/user',function(){
	$GLOBALS['UserRepo']->Save();
});

// user type
$slim_app->get('/userType/:id',function($id){
	$result =  $GLOBALS['UserTypeRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/userType',function(){
	$result =  $GLOBALS['UserTypeRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/userType/:id',function($id){
	 $GLOBALS['UserTypeRepo']->Delete($id);
});
$slim_app->post('/userType',function(){
	 $GLOBALS['UserTypeRepo']->Save();
});

// user role
$slim_app->get('/roles',function(){
	$result =  $GLOBALS['UserRoleRepo']->RoleList();
	echo json_encode($result);
});
$slim_app->get('/userRole',function(){
	$result =  $GLOBALS['UserRoleRepo']->DataList();
	echo json_encode($result);
});
$slim_app->get('/userRole/:id',function($id){
	$result =  $GLOBALS['UserRoleRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->delete('/userRole/:id',function($id){
	$GLOBALS['UserRoleRepo']->Delete($id);
});
$slim_app->post('/userRole',function(){
	$GLOBALS['UserRoleRepo']->Save();
});


?>