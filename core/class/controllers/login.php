<?php 
$slim_app->post('/login',function(){
	$result = $GLOBALS['LoginRepo']->login();
	echo json_encode($result);
});
$slim_app->post('/loginMember',function(){
	$result = $GLOBALS['LoginRepo']->loginMember();
	echo json_encode($result);
});
$slim_app->post('/logout',function(){
	echo $GLOBALS['LoginRepo']->logout();
});
$slim_app->post('/changePassword',function(){
	echo $GLOBALS['LoginRepo']->changePassword();
});
$slim_app->get('/auth',function(){
	echo $GLOBALS['LoginRepo']->auth();
});
$slim_app->get('/authUser',function(){
	echo $GLOBALS['LoginRepo']->authUser();
});
?>