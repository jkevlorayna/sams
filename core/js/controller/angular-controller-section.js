
app.controller('AppSectionController', function ($scope, $http, $q, svcCourseYear,svcSection,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.CourseYearId = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	
	 $scope.load = function () {
		svcSection.list($scope.CourseYearId,$scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.formData = { CourseYearId:$scope.CourseYearId }
	$scope.save = function () {
		svcSection.save($scope.formData).then(function (r) {
			$scope.load();
			$scope.formData = { CourseYearId:$scope.CourseYearId  }
			growl.success("Data Successfully Save");
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcSection.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppSectionModalController',
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

app.controller('AppSectionModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcSection,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcSection.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
