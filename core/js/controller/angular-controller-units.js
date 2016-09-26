
app.controller('AppUnitsController', function ($scope, $http, $q, $location, $filter, svcUnits,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		svcUnits.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	

	
	$scope.pageChanged = function () {
		console.log($scope.pageSize);
			$scope.load();
    }
	

	
	$scope.formData = { }
	$scope.save = function () {
		svcUnits.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {}
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcUnits.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }

	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppUnitsModalController',
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
app.controller('AppUnitsModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcUnits,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcUnits.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	