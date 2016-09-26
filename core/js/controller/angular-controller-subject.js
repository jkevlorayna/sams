app.controller('AppSubjectController', function ($scope, $http, $q, $location, $filter, svcSubject,growl,$uibModal,$stateParams,svcCourse,svcCourseYear) {
	$scope.CourseId = $stateParams.CourseId;
	$scope.CourseYearId = $stateParams.CourseYearId;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	

	$q.all([svcCourse.getById($scope.CourseId),svcCourseYear.getById($scope.CourseYearId)]).then(function(r){
			$scope.course =  r[0].course;
			$scope.code =  r[0].code;
			$scope.year =  r[1].year;
			
		
	})
	
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
		
    $scope.load = function () {
		
		svcSubject.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	
	$scope.PositionSelect = function (search) {
		return svcSubject.getByName(search,$scope.pageNo,$scope.pageSize);
    }

	
	
	
	$scope.pageChanged = function () { $scope.load(); }
	

	$scope.formData = {  }
	$scope.save = function () {
		$scope.formData.CourseYearId = $scope.CourseYearId
		svcSubject.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Saved!")
			$scope.formData = { }
        });
    }
	
	$scope.getById = function (id) {
		svcSubject.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppSubjectModalController',
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


});
app.controller('AppSubjectModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcSubject,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcSubject.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
