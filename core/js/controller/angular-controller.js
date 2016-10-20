
app.controller('AppMainController', function ($rootScope,$scope, $http, $q, $location, $filter, $window,$cookieStore,$uibModal,svcLogin,svcMemberType) {
     $scope.cookieCheck = $cookieStore.get('credentials');
	$rootScope.Sidebar = true;
	$rootScope.Navigation = true;
	
	if($scope.cookieCheck == undefined){
		$scope.session = { userData:{} , isAuthenticated: false,  loading: false };
	}else{
		$scope.session = { userData:$scope.cookieCheck , isAuthenticated: true,  loading: false };
	}

	
	$scope.loadMemberType = function () {
		svcMemberType.list('',0,0).then(function (r) {
            $scope.memberTypeList = r.Results;
        })
    }
    $scope.loadMemberType();
	
   $scope.init = function (isAuthenticated) {
         $scope.session.isAuthenticated = isAuthenticated;
		 if (!$scope.session.isAuthenticated) { 
			 $location.path("/");
		 } 
    }

	$scope.logout = function(){
		svcLogin.logout($scope.formData).then(function (r) {
				$scope.session = { userData:{} , isAuthenticated: false,  loading: false };
				$cookieStore.remove('credentials');
				$location.path("/login"); 
		});
	}

	
	$scope.passwordModal = function (size,id,user) {
			var modal = $uibModal.open({
			templateUrl: 'views/changePassword/modal.html',
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


app.controller('AppChangePasswordModalController', function ( $scope, $http, $q, $location, $uibModalInstance , Id , user , svcLogin,growl ) {
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	$scope.Id = Id;
	$scope.user = user;
});

app.controller('AppLoginController', function ( $scope, $http, $q, $location, svcLogin,$cookieStore,$window ,growl ) {
	
		$scope.formData = {};
		$scope.login = function(){
				svcLogin.loginUser($scope.formData).then(function (r) {
					
					if(r.granted == 'true'){
						$cookieStore.put('credentials', r.Results);
						$scope.cookieCheck = $cookieStore.get('credentials');
				     	$scope.session.userData.name = $scope.cookieCheck.name;
				     	$scope.session.isAuthenticated = true;
					
						if($scope.session.userData.name != null){
							growl.success("Access Granted");
							$location.path('/');
						}
					}else{
						growl.error("Login Failed. Please Check your username and Password");
						$scope.session.isAuthenticated = false;
					}

				}) 
		}
});
