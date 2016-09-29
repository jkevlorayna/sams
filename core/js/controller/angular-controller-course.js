
app.controller('AppCourseController', function ($scope, $http, $q, $location, $filter, svcCourse,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
		$scope.load = function () {
			svcCourse.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
				$scope.list = r.Results;
				$scope.count = r.Count;
			})
		}
		$scope.load();
	
		$scope.pageChanged = function () { $scope.load(); }
	

	$scope.formData = { }
	$scope.save = function () {
		svcCourse.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Saved");
			$scope.formData = { }
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcCourse.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCourseModalController',
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
app.controller('AppCourseModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCourse,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcCourse.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
