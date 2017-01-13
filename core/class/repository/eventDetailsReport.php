<?php 
class EventDetailsReportRepository{
		 function ReportByCourse($EventId,$CourseId,$CourseYearId,$SectionId){
			global $conn;
			$where = "";
			$where .= "AND tbl_event_details.EventId = '$EventId'";
			
			if($CourseId != 'null' && $CourseYearId == 'null' && $SectionId == 'null'){
				$where .= "AND tbl_member.CourseId = '$CourseId'";
			}
			if($CourseId != 'null' && $CourseYearId != 'null' && $SectionId == 'null'){
				$where .= "AND tbl_member.CourseId = '$CourseId'";
				$where .= "AND tbl_member.CourseYearId = '$CourseYearId'";
			}
			if($CourseId != 'null' && $CourseYearId != 'null' && $SectionId != 'null'){
				$where .= "AND tbl_member.CourseId = '$CourseId'";
				$where .= "AND tbl_member.CourseYearId = '$CourseYearId'";
				$where .= "AND tbl_member.SectionId = '$SectionId'";
			}
			
			$query = $conn->query("SELECT
			SUM(InAm) as TotalInAm , 
			SUM(OutAm) as TotalOutAm , 
			SUM(InPm) as TotalInPm , 
			SUM(OutPm) as TotalOutPm 
			FROM tbl_event_details
			LEFT JOIN tbl_member On tbl_member.Id = tbl_event_details.MemberId
			where 1 = 1  $where
			");
			return $query->fetch(PDO::FETCH_OBJ);
		}
}
?>