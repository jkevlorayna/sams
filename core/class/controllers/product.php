<?php 
$slim_app->get('/product/:id',function($id){
	$result = $GLOBALS['ProductRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/productByCategory',function(){
	$result = $GLOBALS['ProductRepo']->DataListByCategory($_GET['CategoryId'],$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->get('/product',function(){
	$result = $GLOBALS['ProductRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/product/:id',function($id){
	$GLOBALS['ProductRepo']->Delete($id);
});
$slim_app->post('/product',function(){
	$GLOBALS['ProductRepo']->Save();
});
$slim_app->get('/productStock/:id',function($id){
	$result = $GLOBALS['ProductRepo']->stock_list($id);
	echo json_encode($result);
});
$slim_app->post('/productStock',function(){
	 $GLOBALS['ProductRepo']->add_stock();
});
?>