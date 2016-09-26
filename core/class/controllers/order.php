<?php 
$slim_app->get('/orderReport',function(){
	$result = $GLOBALS['OrderRepo']->orderReport($_GET['date_from'],$_GET['date_to']);
	echo json_encode($result);
});
$slim_app->get('/orderlist',function(){
	$result = $GLOBALS['OrderRepo']->orderlist($_GET['MemberId']);
	echo json_encode($result);
});
$slim_app->get('/orderlistAdmin',function(){
	$result = $GLOBALS['OrderRepo']->orderlistAdmin($_GET['OrderList'],$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->get('/getOrder/:id',function($id){
	$result = $GLOBALS['OrderRepo']->getOrder($id);
	echo json_encode($result);
});
$slim_app->post('/saveOrder',function(){
	$GLOBALS['OrderRepo']->saveOrder();
});

?>