
app.controller('AppProductStockController', function ($scope, $http, $q, $location, $filter,$stateParams,svcProductStock,growl) {
$scope.id = $stateParams.id
    $scope.load = function () {
		svcProductStock.list($scope.id).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;

        })
    }
    $scope.load();
	
	
	$scope.formData = { ProductId : $scope.id }
	$scope.save = function () {
		svcProductStock.save($scope.formData).then(function (r) {
			$scope.load();
				growl.success("Data Successfully Save");
				$scope.formData = { ProductId : $scope.id  }
        }, function (error) {

        });
    }
	

	


	
});
