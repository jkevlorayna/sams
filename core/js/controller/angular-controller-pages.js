
app.controller('AppPagesController', function ($scope, $http, $q, $location, $filter, svcPages,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
    $scope.load = function () {
		svcPages.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
			console.log($scope.count);
        })
    }
    $scope.load();

	$scope.statusList = [{status:'Active'},{status:'InActive'}];
	
	$scope.pageChanged = function () { $scope.load(); }
	
	$scope.formData = { }
	$scope.save = function () {
		console.log($scope.formData);
		svcPages.save($scope.formData).then(function (r) {
			$scope.load();
			$scope.formData = { }
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcPages.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }


	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppPagesModalController',
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
app.controller('AppPagesModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPages,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPages.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
