
app.controller('AppOrganizationController', function ($scope, $http, $q, $location, $filter, svcOrganization,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
		$scope.load = function () {
			svcOrganization.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
				$scope.list = r.Results;
				$scope.count = r.Count;
			})
		}
		$scope.load();
	
		$scope.pageChanged = function () { $scope.load(); }
	

	$scope.formData = { }
	$scope.save = function () {
		svcOrganization.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Saved");
			$scope.formData = { }
        });
    }
	
	$scope.getById = function (id) {
		svcOrganization.getById(id).then(function (r) {
				$scope.formData =  r
        });
    }
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppOrganizationModalController',
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
app.controller('AppOrganizationModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcOrganization,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcOrganization.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
