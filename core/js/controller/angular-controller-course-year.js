
app.controller('AppCourseYearController', function ($scope, $http, $q, $location, $filter, svcCourseYear,svcCourse,$stateParams,$uibModal,growl) {
	$scope.CourseId = $stateParams.CourseId
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
   
	svcCourse.getById($scope.CourseId).then(function (r) {
			$scope.course =  r.course;
			$scope.code =  r.code;
    });
   
   
    $scope.load = function () {
		svcCourseYear.list($scope.CourseId,$scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	
	$scope.formData = { CourseId:$scope.CourseId }
	$scope.save = function () {
		svcCourseYear.save($scope.formData).then(function (r) {
			$scope.load();
			$scope.formData = { CourseId:$scope.CourseId }
			growl.success("Data Successfully Save");
        });
    }
	
	$scope.getById = function (id) {
		svcCourseYear.getById(id).then(function (r) {
			$scope.formData =  r
        });
    }
	
	


		$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCourseYearModalController',
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
	
	
		$scope.openSection = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/course/section.html',
			controller: 'AppSectionController',
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

app.controller('AppCourseYearModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCourseYear,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcCourseYear.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	

