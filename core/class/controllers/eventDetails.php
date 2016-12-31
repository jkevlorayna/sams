<?php 
$slim_app->get('/event/details/:id',function($id){
	$EventDetailsRepo = new EventDetailsRepository();
	$result = $EventDetailsRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/eventDetail/list',function(){
	$EventDetailsRepo = new EventDetailsRepository();
	
	$result = $EventDetailsRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['EventId'],$_GET['CourseId'],$_GET['CourseYearId'],$_GET['SectionId']);
	echo json_encode($result);
});
$slim_app->delete('/event/details/:id',function($id){
	$EventDetailsRepo = new EventDetailsRepository();
	$EventDetailsRepo->Delete($id);
});
$slim_app->post('/event/details',function(){
	$EventDetailsRepo = new EventDetailsRepository();
	$MemberRepo = new MemberRepository();
	$EventRepo = new EventRepository();
	
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());	
	
	$Member = $MemberRepo->GetByBarcode($POST->Barcode);


		if(is_object($Member)){
			if($Member->EnableBarcode == 1){
				$POST->MemberId = $Member->Id;

				$MemberEvent = $EventRepo->GetMember($POST->EventId,$POST->MemberId);

				if(is_object($MemberEvent)){
					$POST->Id = $MemberEvent->Id;
					$POST->InAm = $MemberEvent->InAm;
					$POST->OutAm = $MemberEvent->OutAm;
					$POST->InPm = $MemberEvent->InPm;
					$POST->OutPm = $MemberEvent->OutPm;
					
				}
				if($POST->TimeType == "Time-IN AM"){ $POST->InAm = 1; }
				if($POST->TimeType == "Time-OUT AM"){ $POST->OutAm = 1; }
				if($POST->TimeType == "Time-IN PM"){ $POST->InPm = 1; }
				if($POST->TimeType == "Time-OUT PM"){ $POST->OutPm = 1; }
				
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