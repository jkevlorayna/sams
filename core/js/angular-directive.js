
 app.directive('changePassword',function(svcLogin,growl,svcMember) {
    return {
		restrict: 'E',
		link: function($scope, element, attrs) {
			$scope.Id = attrs.id;
			$scope.user = attrs.user;
			
					$scope.save = function(){
						if($scope.user == 'Admin'){
							$scope.formData.user_id = $scope.Id;
							var dataPromise = svcLogin.changePassword($scope.formData);
						}else{
							$scope.formData.Id = $scope.Id;
							
							var dataPromise = svcMember.changePassword($scope.formData);
						}
						
						dataPromise.then(function(r){
							if(r == "cpFalse"){
								growl.error("Current Password Not Match");
							}else{
								$scope.close();
								growl.success("Password Successfully Change");
							}
						});	
						
						
					}
					
					$scope.passwordCorrect = false;
					$scope.ComparePassword = function(password,cpassword){
						$scope.passwordCorrect = (password==cpassword)?false:true;
					}
		},
	   templateUrl: 'views/changePassword/form.html',
    };
 });
app.directive('ngFiles', ['$parse', function ($parse) {

            function fn_link(scope, element, attrs) {
                var onChange = $parse(attrs.ngFiles);
                element.on('change', function (event) {
                    onChange(scope, { $files: event.target.files });
                });
            };

            return {
                link: fn_link
            }
}]);
app.directive('checkImage', function($http) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            attrs.$observe('ngSrc', function(ngSrc) {
                $http.get(ngSrc).success(function(){
                    // alert('image exist');
                }).error(function(){
                    // alert('image not exist');
                    element.attr('src', 'core/images/noimage.png'); // set default image
                });
            });
        }
    };
});
