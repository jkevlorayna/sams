<?php 
$slim_app->get('/MemberOrderList',function(){
	$result = $GLOBALS['CartRepo']->MemberOrderList($_GET['MemberId']);
	echo json_encode($result);
});
$slim_app->post('/AddToCart',function(){
	echo $GLOBALS['CartRepo']->Add();
});
$slim_app->post('/sendOrder',function(){
	echo $GLOBALS['CartRepo']->sendOrder();
});
$slim_app->delete('/cart/:id',function($id){
	echo $GLOBALS['CartRepo']->Delete($id);
});
?>