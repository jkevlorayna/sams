<?php 
$slim_app->get('/books/:id',function($id){
	$result = $GLOBALS['BooksRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/books',function(){
	$result = $GLOBALS['BooksRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['status'],$_GET['archive']);
	echo json_encode($result);
});
$slim_app->delete('/books/:id',function($id){
	$GLOBALS['BooksRepo']->Delete($id);
});
$slim_app->post('/books',function(){
	 $GLOBALS['BooksRepo']->Save();
});
$slim_app->post('/Borrow',function(){
	$GLOBALS['BooksRepo']->Borrow();
});
$slim_app->get('/BorrowList',function(){
	$result = $GLOBALS['BooksRepo']->BorrowList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	foreach($result['Results'] as $row){
		$row['Member'] = $GLOBALS['MemberRepo']->Get($row['MemberId']);
		$row['BorrowDetails'] = $GLOBALS['BooksRepo']->BorrowDetails($row['Id']);
		$ArrayData[] = $row;
	}
	
	$data = array();
	$data['Results'] = $ArrayData;
	$data['Count'] = $result['Count'];
	echo json_encode($data);
});
$slim_app->get('/BorrowDetails/:id',function($id){
	$row = $GLOBALS['BooksRepo']->GetBorrow($id);
	$row['BorrowDetails'] = $GLOBALS['BooksRepo']->BorrowDetails($row['Id']);
	$row['Member'] = $GLOBALS['MemberRepo']->Get($row['MemberId']);
	$result = $row;

	echo json_encode($result);
});
?>