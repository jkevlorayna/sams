
app.controller('AppUserController', function ($scope, $http, $q, $location, $filter, svcUser,svcUserType,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		svcUser.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	
	$scope.UserTypeListLoad = function () {
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		svcUserType.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.userTypeList = r.Results;
        })
    }
	$scope.UserTypeListLoad();
	

	$scope.pageChanged = function () { $scope.load(); }
	
	$scope.formData = { }
	$scope.save = function () {
		svcUser.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = { }
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcUser.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppUserModalController',
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
app.controller('AppUserModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcUser,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	$scope.delete = function () {
		svcUser.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	






app.controller('AppUserRoleController', function ($scope, $http, $q, $location, $filter, svcUser,svcUserRole,growl,$uibModal,$stateParams) {
$scope.UserId = $stateParams.UserId;

    $scope.loadRole = function () {
		svcUserRole.roles($scope.UserId).then(function (r) {
			  
			angular.forEach(r.Results,function(row){
				row.UserRole.UserId = $scope.UserId;
				row.UserRole.RoleId = row.Id;
			})
          $scope.RoleList = r.Results;
        })
    }
    $scope.loadRole();

   
	$scope.Save = function () {
		console.log($scope.RoleList);
		svcUserRole.save($scope.RoleList).then(function (r) {
			$scope.loadRole();
			growl.success("Data Successfully Save");
			$scope.formData = { UserId:$scope.UserId  }
        });
    }
	
	$scope.getById = function (id) {
		svcUserRole.getById(id).then(function (r) {
				$scope.formData =  r
        });
    }
	

	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppUserRoleModalController',
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
app.controller('AppUserRoleModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcUserRole,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	$scope.delete = function () {
		svcUserRole.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	










app.controller('AppUserTypeController', function ($scope, $http, $q, $location, $filter, svcUserType,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		svcUserType.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	
	$scope.formData = { }
	$scope.save = function () {
		svcUserType.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = { }
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcUserType.getById(id).then(function (r) {
			$scope.formData =  r
        }, function (error) {

        });
    }

	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppUserTypeModalController',
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
app.controller('AppUserTypeModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcUserType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	$scope.delete = function () {
		svcUserType.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	