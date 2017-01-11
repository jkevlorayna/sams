app.controller('AppEventController', function ($scope, $http, $q, $location, svcEvent,growl,$uibModal,svcSemester,svcSchoolYear,$filter) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
	$q.all([svcSemester.list('',0,0),svcSchoolYear.list('',0,0)]).then(function(r){
		$scope.SemesterList = r[0].Results;
		$scope.SchoolYearList = r[1].Results;
		
		$scope.CurrentSemester = $filter('filter')($scope.SemesterList, {Current:1})[0];
		$scope.CurrentSchoolYear = $filter('filter')($scope.SchoolYearList, {Current:1})[0];
		
		$scope.Semester = $scope.CurrentSemester.Semester;
		$scope.SchoolYear = $scope.CurrentSchoolYear.Id

		
			$scope.load = function () {
				svcEvent.list($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.Semester,$scope.SchoolYear,'').then(function (r) {
					$scope.list = r.Results;
					$scope.count = r.Count;
				})
			}
			$scope.load();
			
			$scope.pageChanged = function () { $scope.load();}
	})
	

	

	


	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppEventModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};
	
	
		
	$scope.openFormModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/event/formModal.html',
			controller: 'AppEventFormModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				},Semester: function () {
					return $scope.Semester;
				},SchoolYear: function () {
					return $scope.SchoolYear;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};
	
	
});
app.controller('AppEventFormModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEvent,growl,$uibModal,dataId,$uibModalInstance,Semester,SchoolYear) {
	$scope.Id = dataId;
	$scope.Semester = Semester;
	$scope.SchoolYear = SchoolYear;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}

	$scope.getById = function (id) {
		svcEvent.getById($scope.Id).then(function (r) {
						$scope.formData =  r;
						$scope.formData.EventDate = new Date(r.EventDate);
		})
	}


	
	if($scope.Id == 0){
		$scope.formData = {};
		$scope.formData.EventDate = new Date();
	}else{
		$scope.getById()
	}
	
	$scope.save = function () {
		$scope.formData.Semester = $scope.Semester;	
		$scope.formData.SchoolYearId = $scope.SchoolYear;	
		svcEvent.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
			$scope.close();
        });
    }
	
	
});	
app.controller('AppEventModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEvent,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcEvent.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	

app.controller('AppEventDetailsController', function ($rootScope,$scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams,svcEventDetails,svcEvent,svcCourse,svcCourseYear,svcSection) {
	$scope.Id = $stateParams.Id;
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){
			$scope.searchText = '';
	} 
	$scope.getById = function(){
		svcEvent.getById($scope.Id).then(function(r){
			$scope.formData = r;
		})
	}	
	$scope.getById();
	
	// Course / year / section filter
	$scope.CourseId = null;	
	$scope.CourseYearId = null;	
	$scope.SectionId = null;
	$scope.loadCourse = function(){
		svcCourse.list('',0,0).then(function(r){
			$scope.courseList = r.Results;
		})
	}
	$scope.loadCourse();
	
	$scope.loadCourseYear = function(CourseId){
		svcCourseYear.list(CourseId,'',0,0).then(function(r){
			$scope.yearList = r.Results;
		})
		$scope.load();
	}
	
	$scope.loadSection = function(YearId){
		svcSection.list(YearId,'',0,0).then(function(r){
			$scope.sectionList = YearId != null ?  r.Results : null;
		})
		$scope.load();
	}
	
	$scope.selectSection = function(){
		$scope.load();
	}
	// end Course / year / section filter
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
	$scope.load = function(){
		console.log($scope.searchText);
		svcEventDetails.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.Id,$scope.CourseId,$scope.CourseYearId,$scope.SectionId).then(function(r){
			$scope.list = r.Results;
			$scope.count = r.Count;
		})
	}
	$scope.load();
	
	$scope.pageChanged = function(){
		$scope.load();
	}
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppEventDetailsModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};

	$scope.openFilterModal = function (size,EventId,Report) {
			var modal = $uibModal.open({
			templateUrl: 'views/event/report/filterform.html',
			controller: 'AppEventDetailsFilterModalController',
			size: size,
			resolve: {
				EventId:function(){
					return EventId;
				},Report:function(){
					return Report;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};

	
});	
app.controller('AppEventDetailsFilterModalController', function ($state,EventId,$rootScope,$location,$scope,growl,$uibModalInstance,svcCourse,svcCourseYear,svcSection) {
	// Course / year / section filter
	$scope.formData = {};
	$scope.CourseId = null;	
	$scope.CourseYearId = null;	
	$scope.SectionId = null;
	$scope.loadCourse = function(){
		svcCourse.list('',0,0).then(function(r){
			$scope.courseList = r.Results;
		})
	}
	$scope.loadCourse();
	
	$scope.loadCourseYear = function(CourseId){
		svcCourseYear.list(CourseId,'',0,0).then(function(r){
			$scope.yearList = r.Results;
		})
	}
	
	$scope.loadSection = function(YearId){
		svcSection.list(YearId,'',0,0).then(function(r){
			$scope.sectionList = YearId != null ?  r.Results : null;
		})
	}
	
	$scope.ViewReport = function(){
		  $state.go('eventReportCourseYear', {Id: EventId,CourseId:$scope.formData.CourseId});
		  	$uibModalInstance.dismiss();
	}
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	// end Course / year / section filter
});	
app.controller('AppEventDetailsModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEventDetails,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcEventDetails.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	

app.controller('AppEventFormController', function ($rootScope,$scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams,svcEventDetails,$timeout,$interval) {
$scope.Id = $stateParams.Id;
$rootScope.Sidebar = false;
$rootScope.Navigation = false;
$scope.Message = null;
	$scope.getById = function(){
		svcEvent.getById($scope.Id).then(function(r){
			$scope.formData = r;
			$scope.formData.Id = 0;
		})
	}
	$scope.getById();
	
   $scope.tick = function() {
    $scope.clock = Date.now();
  }
  $scope.tick();
  $interval($scope.tick, 1000);
  

	$scope.save = function () {
		$scope.formData.EventId = $scope.Id;
		if($scope.formData.TimeType == 'Time-IN AM'){
			$scope.formData.InAmDateTime = moment(new Date).format("YYYY-MM-DD HH:mm");
		}
		if($scope.formData.TimeType == 'Time-OUT AM'){
			$scope.formData.OutAmDateTime = moment(new Date).format("YYYY-MM-DD HH:mm");
		}
		if($scope.formData.TimeType == 'Time-IN PM'){
			$scope.formData.InPmDateTime = moment(new Date).format("YYYY-MM-DD HH:mm");
		}
		if($scope.formData.TimeType == 'Time-OUT PM'){
			$scope.formData.OutPmDateTime = moment(new Date).format("YYYY-MM-DD HH:mm");
		}
		svcEventDetails.Save($scope.formData).then(function (r) {
			// console.log(r);
			if(r == 0){
				growl.error("Member Does Not Exist");
			}else{
				growl.success("Data Successfully Save");
				if($scope.formData.TimeType == 'Time-IN AM' || $scope.formData.TimeType == 'Time-IN PM'){
					$scope.Message = "Welcome " + r.firstname + " " + r.lastname;
				}
				if($scope.formData.TimeType == 'Time-OUT AM' || $scope.formData.TimeType == 'Time-OUT PM'){
					$scope.Message = "Goodbye " + r.firstname + " " + r.lastname;
				}
				$scope.ImageUrl = 'core/class/uploads/'+r.ImageUrl;
				    $timeout(function() { $scope.Message = null; }, 5000);
			}
				
				$scope.formData = { EventId : $scope.Id  }
				$scope.getById();
        });
    }
	
});


app.controller('AppEventDetailsReportCourseController', function ($rootScope,$scope, $http, $q, $location, svcEventDetailsReport,growl,$uibModal,$stateParams,svcEventDetails,svcEvent,svcCourse,svcCourseYear,svcSection) {
	$scope.Id = $stateParams.Id;
	svcEvent.getById($scope.Id).then(function(r){
		$scope.formData = r;
	})
	$scope.TotalInAmTotal = 0;
	$scope.TotalOutAmTotal = 0;
	$scope.TotalInPmTotal = 0;
	$scope.TotalOutPmTotal = 0;
	
	svcEventDetailsReport.ReportByCourse($scope.Id,null,null,null).then(function(r){
		$scope.reportlist = r.Results;
		angular.forEach($scope.reportlist,function(row){
			$scope.TotalInAmTotal += row.TotalInAm;
			$scope.TotalOutAmTotal += row.TotalOutAm;
			$scope.TotalInPmTotal += row.TotalInPm;
			$scope.TotalOutPmTotal += row.TotalOutPm;
		})
	})
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});	
app.controller('AppEventDetailsReportCourseYearController', function ($rootScope,$scope, $http, $q, $location, svcEventDetailsReport,growl,$uibModal,$stateParams,svcEventDetails,svcEvent,svcCourse,svcCourseYear,svcSection) {
	$scope.Id = $stateParams.Id;
	$scope.CourseId = $stateParams.CourseId;
	
	svcEvent.getById($scope.Id).then(function(r){
		$scope.formData = r;
	})
	
	$q.all([svcCourse.getById($scope.CourseId)]).then(function(r){
		$scope.Course = r[0];
		
			$scope.TotalInAmTotal = 0;
			$scope.TotalOutAmTotal = 0;
			$scope.TotalInPmTotal = 0;
			$scope.TotalOutPmTotal = 0;
	
		svcEventDetailsReport.ReportByCourse($scope.Id,$scope.CourseId,null,null).then(function(r){
			$scope.reportlist = r.Results;
			
			angular.forEach($scope.reportlist,function(row){
				$scope.TotalInAmTotal += row.TotalInAm;
				$scope.TotalOutAmTotal += row.TotalOutAm;
				$scope.TotalInPmTotal += row.TotalInPm;
				$scope.TotalOutPmTotal += row.TotalOutPm;
			})
			
		})
	})
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});	
