
app.controller('AppMemberController', function ($scope, $http, $q, $filter, svcMember,svcMemberType,growl,$uibModal,$stateParams,svcSemester,svcSchoolYear) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		$scope.type = $stateParams.type;
		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
		
		$q.all([svcSemester.list('',0,0),svcSchoolYear.list('',0,0)]).then(function(r){
		$scope.SemesterList = r[0].Results;
		$scope.SchoolYearList = r[1].Results;
		
		$scope.CurrentSemester = $filter('filter')($scope.SemesterList, {Current:1})[0];
		$scope.CurrentSchoolYear = $filter('filter')($scope.SchoolYearList, {Current:1})[0];
		
		$scope.Semester = $scope.CurrentSemester.Semester;
		$scope.SchoolYear = $scope.CurrentSchoolYear.Id

		$scope.load = function () {
			svcMember.list($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.type).then(function (r) {
				$scope.list = r.Results;
				$scope.count = r.Count;
			})
		}
		$scope.load();
	})
		
		

	
	
	 $scope.loadMemberType = function () {
		svcMemberType.getById($scope.type).then(function (r) {
            $scope.memberType = r;
        })
    }
    $scope.loadMemberType();
	
	
	$scope.genderList = [{gender:'Male'},{gender:'Female'}];
	
	$scope.pageChanged = function () { $scope.load(); }
	
	
	$scope.formData = {}
	$scope.save = function () {
		svcMember.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Saved!")
			$scope.load();
			$scope.formData = {}
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcMember.getById(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppMemberModalController',
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

	$scope.moveToModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/moveModal.html',
			controller: 'AppMemberMoveModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { 
				$scope.load();
			}, function () { 
				$scope.load();
			});
	};
	
		$scope.viewFullInfoModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/fullInfo.html',
			controller: 'AppMemberFullInfoModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { 
				$scope.load();
			}, function () { 
				$scope.load();
			});
	};
	
	$scope.ChangePicture = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/changePicture.html',
			controller: 'AppChangePictureModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { 
				$scope.load();
			}, function () { 
				$scope.load();
			});
	};
	
	
});
app.controller('AppMemberModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcMember.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
app.controller('AppMemberMoveModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,svcMemberType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;

	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.memberTypeList = function(){
		svcMemberType.list('',0,0).then(function(r){
			$scope.memberTypeList = r.Results;
		})
	}
	$scope.memberTypeList();
	
	$scope.formData = {};
	$scope.getById = function(){
		svcMember.getById($scope.id).then(function(r){
			$scope.formData = r;
		})
	}
	$scope.getById();	

	$scope.Save = function(){
		$scope.formData.Transfer = true;
		svcMember.save($scope.formData).then(function(r){
			growl.success("Data Successfully Move");
			$uibModalInstance.close();
		})	
	}
	

});	

app.controller('AppChangePictureModalController', function (svcSemester,svcSchoolYear,$rootScope,$scope, $http, $q,  $filter, svcMember,svcMemberType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	
	$scope.formData = {};
	$scope.getById = function(){
		svcMember.getById($scope.id).then(function(r){
			$scope.formData = r;
		})
	}
	$scope.getById();	
	
	$scope.fileData = new FormData();
    $scope.getTheFiles = function (files) {
        angular.forEach(files, function (value, key) {
            $scope.fileData.append(key, value);
        });
    };
		$scope.save = function () {
		svcMember.signUp($scope.formData).then(function (r) {     
				svcMember.Upload($scope.fileData,r.Id).then(function(r){
					$scope.close();
				})
        },function(){
			growl.error('Ops Something Went Wrong');
		});
    }


	
});	


app.controller('AppMemberFullInfoModalController', function (svcSemester,svcSchoolYear,$rootScope,$scope, $http, $q,  $filter, svcMember,svcMemberType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	
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

			$scope.GetAttendance = function(){
			svcMember.GetAttendance($scope.id,$scope.Semester,$scope.SchoolYear).then(function(r){
					$scope.AttendanceList = r;
				})
			}
			$scope.GetAttendance();	
	

	})
	
	
	
	$scope.formData = {};
	$scope.getById = function(){
		svcMember.getById($scope.id).then(function(r){
			$scope.formData = r;
		})
	}
	$scope.getById();	
	

	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});	
app.controller('AppSignUpController', function ($scope, $http, $q, $filter, svcMember,growl,$stateParams) {

	$scope.save = function () {
		console.log($scope.formData);
			svcMember.signUp($scope.formData).then(function (r) {
			 growl.success('Data Successfully Saved');
        });
    }
});


app.controller('AppStudentSignUpController', function ($scope, $http, $q, $filter,svcMemberType, svcMember,growl,svcCourse,svcCourseYear,svcSection,$stateParams,$location) {
	$scope.Id = $stateParams.Id;
	$scope.type = $stateParams.type;
	$scope.PageTitle = '';
	svcMemberType.getById($scope.type).then(function(r){
		$scope.PageTitle = $scope.Id == 0 ? 'Add New ' + r.type  : 'Update ' + r.type + ' Data';
	})	
		
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
	
	$scope.fileData = new FormData();
    $scope.getTheFiles = function (files) {
        angular.forEach(files, function (value, key) {
            $scope.fileData.append(key, value);
        });
    };

	$scope.save = function () {
		svcMember.signUp($scope.formData).then(function (r) {     
			if(r == 'exist'){
				growl.error('Id Number Already Exist');
			}else{
				growl.success('Data Successfully Saved');
				svcMember.Upload($scope.fileData,r.Id).then(function(r){
					$location.path('/member/list/'+$scope.type);
				})
				
			}
			
			
        },function(){
			growl.error('Ops Something Went Wrong');
		});
    }
	


	$scope.getById = function(){
		svcMember.getById($scope.Id).then(function (r) {
			$scope.formData = r;
			
			if($scope.Id == 0){
				$scope.yearList = null;
				$scope.sectionList = null;
			}else{
				$scope.loadCourseYear($scope.formData.CourseId);
				$scope.loadSection($scope.formData.CourseYearId);
				
			}
        });
	}
	
	$scope.formData = $scope.Id == 0 ? { MemberTypeId:$scope.type } : $scope.getById() ;
});
