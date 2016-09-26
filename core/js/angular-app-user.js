var MainFolder = 'angular';
var BasePath = 'core';
var app = angular.module('app', ['ui.router','ui.bootstrap','ngSanitize', 'ui.select','angular-growl','ngCookies','ngAnimate']);

app.run(function ($rootScope, $location,$cookieStore,$window,svcLogin) {
   // var cookieCheck = $cookieStore.get('credentials');
   $rootScope.session = {};


    $rootScope.$on("$stateChangeStart",function() { 
   		svcLogin.authUser().then(function (r) {
			if(r == "false"){ 
				
			}else{
				 $rootScope.session.UserIsAuthenticated = true;
			}
		});
    });
   


});

app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/")
    $stateProvider
	    .state('home',
        {
            url: '/',
            templateUrl: "user/home.html",
            controller: "",
        })
		  .state('product',
        {
            url: '/product/:category_id',
            templateUrl: "user/product.html",
            controller: "AppUserProductController",
        })
		 .state('cart',
        {
            url: '/cart',
            templateUrl: "user/cart.html",
            controller: "AppUserCartController",
        })
		.state('page',
        {
            url: '/page/:id',
            templateUrl: "user/page.html",
            controller: "",
        })
		.state('signup',
        {
            url: '/signup',
            templateUrl: "user/signup.html",
            controller: "AppSignUpController",
        })
		.state('signupStudent',
        {
            url: '/signup/student',
            templateUrl: "user/student/signup.html",
            controller: "AppStudentSignUpController",
        })
		.state('login',
        {
            url: '/login',
            templateUrl: "user/login.html",
            controller: "AppLoginMemberController",
        })
		
		// order
				.state('order',
				{
					url: '/order',
					templateUrl: "user/order/index.html",
					controller: "",
				})
				.state('order.history',
				{
					url: '/history',
					templateUrl: "user/order/history.html",
					controller: "AppUserOrderHistoryController",
				})
				.state('order.details',
				{
					url: '/details/:id',
					templateUrl: "user/order/details.html",
					controller: "AppUserOrderDetailsController",
				})
		// end order

}]);
app.config(['growlProvider', function(growlProvider) {
  growlProvider.globalTimeToLive(5000);
}]);