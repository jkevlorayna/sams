
app.controller('AppSemesterController', function ($scope, $http, $q, $location, $filter, svcSemester,$uibModal,growl) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
    $scope.load = function () {

		svcSemester.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
		
	$scope.pageChanged = function () { $scope.load(); }
	

	
	$scope.formData = { }
	$scope.save = function () {
		svcSemester.save($scope.formData).then(function (r) {
			$scope.load();
			$scope.formData = { }
			growl.success("Data Successfully Save");
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcSemester.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }


	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppSemesterModalController',
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
app.controller('AppSemesterModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcSemester,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcSemester.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
