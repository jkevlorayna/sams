<?php 
$slim_app->post('/login',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$LoginRepo = new LoginRepository();

	$result = $LoginRepo->login($LoginRepo->Transform($POST));
	echo json_encode($result);
});
$slim_app->post('/loginMember',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$LoginRepo = new LoginRepository();
	
	$result = $LoginRepo->loginMember($LoginRepo->Transform($POST));
	echo json_encode($result);
});
$slim_app->post('/logout',function(){
	$LoginRepo = new LoginRepository();
	
	echo $LoginRepo->logout();
});
$slim_app->post('/changePassword',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$LoginRepo = new LoginRepository();
	
	echo $LoginRepo->changePassword($LoginRepo->Transform($POST));
});
$slim_app->get('/auth',function(){
	$LoginRepo = new LoginRepository();
	echo $LoginRepo->auth();
});
$slim_app->get('/authUser',function(){
	$LoginRepo = new LoginRepository();
	echo $LoginRepo->authUser();
});
?>