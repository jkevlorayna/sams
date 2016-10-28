<?php 
$slim_app->get('/event/details/:id',function($id){
	$EventDetailsRepo = new EventDetailsRepository();
	$result = $EventDetailsRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/eventDetail/list',function(){
	$EventDetailsRepo = new EventDetailsRepository();
	
	$result = $EventDetailsRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['EventId']);
	echo json_encode($result);
});
$slim_app->delete('/event/details/:id',function($id){
	$EventDetailsRepo = new EventDetailsRepository();
	$EventDetailsRepo->Delete($id);
});
$slim_app->post('/event/details',function(){
	$EventDetailsRepo = new EventDetailsRepository();
	$MemberRepo = new MemberRepository();
	
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());	
	
	$Member = $MemberRepo->GetByBarcode($POST->Barcode);


		if(is_object($Member)){
			if($Member->EnableBarcode == 1){
				$POST->MemberId = $Member->Id;
				$EventDetailsRepo->Save($EventDetailsRepo->Transform($POST));
				echo json_encode($Member);
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}

	
});
?>