app.controller('AppSettingController', function ($scope, $http, $q, $location, $filter, svcSetting,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
		$scope.load = function () {
			svcSetting.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
				$scope.list = r.Results;
				$scope.count = r.Count;
			})
		}
		$scope.load();
	
	
	
	$scope.pageChanged = function () { $scope.load(); }
	

	
	$scope.formData = { }
	$scope.save = function () {
		svcSetting.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
			$scope.formData = { }
			$scope.load();
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcSetting.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }

	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppSettingModalController',
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
app.controller('AppSettingModalController', function ($scope, $q, svcSetting,growl,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcSetting.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	