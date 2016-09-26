app.controller('AppUserMainController', function ($rootScope,$scope, $http, $q, $location, $window,$cookieStore,$uibModal,svcLogin,svcPages,svcOrder) {
	$scope.cookieCheck = $cookieStore.get('credentials');
	
	if($scope.cookieCheck == undefined){
		$rootScope.session = { userData:{} , UserIsAuthenticated: false,  loading: false };
	}else{
		$rootScope.session = { userData:$scope.cookieCheck , UserIsAuthenticated: true,  loading: false };
	}
	
	$scope.logout = function(){
		svcLogin.logout($scope.formData).then(function (r) {
				$rootScope.session = { userData:{} , UserIsAuthenticated: false,  loading: false };
				$cookieStore.remove('credentials');
				$location.path("/"); 
		});
	}
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
     $scope.loadPages = function () {
		svcPages.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
			
        })
    }
    $scope.loadPages();
	
	
	$scope.passwordModal = function (size,id,user) {
			var modal = $uibModal.open({
			templateUrl: "/" + MainFolder +'/admin/views/changePassword/modal.html',
			controller: 'AppChangePasswordModalController',
			size: size,
			resolve: {
				Id: function () {
					return id;
				},user:function(){
					return user;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				
			});
	};
	
});

app.controller('AppLoginMemberController', function ($rootScope,$scope, $http, $q, $location, svcLogin,$cookieStore,$window ,growl ) {
	
		$scope.formData = {};
		$scope.login = function(){
				svcLogin.loginMember($scope.formData).then(function (r) {
					
					if(r.granted == 'true'){
						$cookieStore.put('credentials', r.Results);
						$scope.cookieCheck = $cookieStore.get('credentials');
				     	$rootScope.session.UserIsAuthenticated = true;
				     	$rootScope.session.userData = $scope.cookieCheck;
						
						growl.success("Access Granted");
						$location.path("/")
						
					}else{
						growl.error("Login Failed. Please Check your username and Password");
						$scope.session.UserIsAuthenticated = false;
						
					}

				}) 
		}
});