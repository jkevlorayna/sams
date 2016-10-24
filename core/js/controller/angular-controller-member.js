
app.controller('AppMemberController', function ($scope, $http, $q, $filter, svcMember,svcMemberType,growl,$uibModal,$stateParams ) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		$scope.type = $stateParams.type;
		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
		svcMember.list($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.type).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	
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

app.controller('AppMemberFullInfoModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,svcMemberType,growl,$uibModal,dataId,$uibModalInstance) {
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
});	
app.controller('AppSignUpController', function ($scope, $http, $q, $filter, svcMember,growl,$stateParams) {

	$scope.save = function () {
		console.log($scope.formData);
			svcMember.signUp($scope.formData).then(function (r) {
			 growl.success('Data Successfully Saved');
        });
    }
});


app.controller('AppStudentSignUpController', function ($scope, $http, $q, $filter, svcMember,growl,svcCourse,svcCourseYear,svcSection,$stateParams,$location) {
	$scope.Id = $stateParams.Id;
	$scope.type = $stateParams.type;
		
		
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
	


	$scope.save = function () {
		svcMember.signUp($scope.formData).then(function (r) {
			if(r == 'exist'){
				growl.error('Id Number Already Exist');
			}else{
				growl.success('Data Successfully Saved');
				$location.path('/member/list/'+$scope.type);
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
