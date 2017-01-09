<?php 
$slim_app->get('/event-report/:EventId/:CourseId/:CourseYearId/:SectionId',function($EventId,$CourseId,$CourseYearId,$SectionId){
	$EventDetailsReportRepo = new EventDetailsReportRepository();
	$CourseRepo = new CourseRepository();
	$CourseYearRepo = new CourseYearRepository();
	$SectionRepo = new SectionRepository();

	if($CourseId == 'null' && $CourseYearId == 'null' && $SectionId == 'null'){
		$result = $CourseRepo->DataList('',0,0);
	}
	if($CourseId != 'null' && $CourseYearId == 'null' && $SectionId == 'null'){
		$result = $CourseYearRepo->DataList($CourseId,'',0,0);
	}

	foreach($result['Results'] as $row){

		if($CourseId == 'null' && $CourseYearId == 'null' && $SectionId == 'null'){
			$row->Name = $row->course + ' ' + $row->code;
			$data = $EventDetailsReportRepo->ReportByCourse($EventId,$row->Id,$CourseYearId,$SectionId);
		}
		if($CourseId != 'null' && $CourseYearId == 'null' && $SectionId == 'null'){
			$row->Name = $row->year;
			$data = $EventDetailsReportRepo->ReportByCourse($EventId,$CourseId,$row->Id,$SectionId);
		}

		 if($data != null){
			 $row->TotalInAm  = $data->TotalInAm == null ? (int) 0 : (int) $data->TotalInAm;
			 $row->TotalOutAm = $data->TotalOutAm == null ? (int) 0 : (int) $data->TotalOutAm;
			 $row->TotalInPm = $data->TotalInPm == null ?  (int) 0 : (int) $data->TotalInPm;
			 $row->TotalOutPm = $data->TotalOutPm == null ? (int) 0 : (int) $data->TotalOutPm;
		 }
	}
	echo json_encode($result);
});
?>