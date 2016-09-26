var MainFolder = 'sams';
var MainFolder = 'sams';
var BasePath = 'core';
var app = angular.module('app', ['ui.router','ui.bootstrap','ngSanitize', 'ui.select','angular-growl','ngCookies','ngAnimate','checklist-model']);
app.run(function ($rootScope, $location,$cookieStore,$window,svcLogin) {
   var cookieCheck = $cookieStore.get('credentials');
   


    $rootScope.$on("$stateChangeStart",function() { 
   		svcLogin.auth().then(function (r) {
			if(r == "false"){ 
				$location.path("/login");
			}
		});
    });
   


});
app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/login")
    $stateProvider
	    .state('home',
        {
            url: '/',
            templateUrl: "views/home.html",
            controller: "",
        })
        .state('login',
        {
            url: '/login',
            templateUrl: "views/login.html",
            controller: "AppLoginController",
        })
		 .state('year',
        {
            url: '/year',
            templateUrl: "views/year.html",
            controller: "AppYearController",
			
        })
		 .state('category',
        {
            url: '/category',
            templateUrl: "views/category.html",
            controller: "AppCategoryController",
        })
		
		// place
			.state('place',
			{
				url: '/place',
				templateUrl: "views/place/index.html",
				controller: "",
			})
			.state('place.list',
			{
				url: '/list',
				templateUrl: "views/place/list.html",
				controller: "AppPlaceController",
			})
			.state('place.form',
			{
				url: '/form/:Id',
				templateUrl: "views/place/form.html",
				controller: "AppPlaceFormController",
			})
		// end place
		
		// member
			.state('member',
			{
				url: '/member',
				templateUrl: "views/member/index.html",
				controller: "",
			})
			.state('member.list',
			{
				url: '/list/:type',
				templateUrl: "views/member/list.html",
				controller: "AppMemberController",
			})
			.state('member.form',
			{
				url: '/form/:type/:Id',
				templateUrl: "views/member/form.html",
				controller: "AppStudentSignUpController",
			})
			.state('member.type',
			{
				url: '/type',
				templateUrl: "views/member/type.html",
				controller: "AppMemberTypeController",
			})
		// end member
		
		//user 
			.state('user',
			{
				url: '/user',
				templateUrl: "views/user/index.html",
				controller: "",
			})
			.state('user.list',
			{
				url: '/list',
				templateUrl: "views/user/list.html",
				controller: "AppUserController",
			})
			.state('user.type',
			{
				url: '/type',
				templateUrl: "views/user/type.html",
				controller: "AppUserTypeController",
			})
			.state('user.roles',
			{
				url: '/roles/:UserId',
				templateUrl: "views/user/roles.html",
				controller: "AppUserRoleController",
			})
		// end user
		//course
		.state('course',
        {
            url: '/course',
            templateUrl: "views/course/index.html",
            controller: "",
        })
		.state('course.list',
        {
            url: '/list',
            templateUrl: "views/course/list.html",
            controller: "AppCourseController",
        })
		.state('course.year',
        {
            url: '/:CourseId/year',
            templateUrl: "views/course/year.html",
            controller: "AppCourseYearController",
        })
		.state('course.YearSubject',
        {
            url: '/:CourseId/year/:CourseYearId/subject',
            templateUrl: "views/course/subject.html",
            controller: "AppSubjectController",
        })
		.state('courseyear',
        {
            url: '/course/:CourseId/year',
            templateUrl: "views/course-year.html",
            controller: "AppCourseYearController",
        })
		// end course
		// event
		.state('event',
        {
            url: '/event/',
            templateUrl: "views/event/index.html",
            controller: "",
        })
		.state('event.list',
        {
            url: 'list',
            templateUrl: "views/event/list.html",
            controller: "AppEventController",
        })
		.state('event.details',
        {
            url: 'details/:Id',
            templateUrl: "views/event/details.html",
            controller: "AppEventDetailsController",
        })
		.state('event.form',
        {
            url: 'form/:Id',
            templateUrl: "views/event/form.html",
            controller: "AppEventFormController",
        })
		// end event
		.state('department',
        {
            url: '/department',
            templateUrl: "views/department.html",
            controller: "AppDepartmentController",
        })
		.state('position',
        {
            url: '/position',
            templateUrl: "views/position.html",
            controller: "AppPositionController",
        })
		.state('semester',
        {
            url: '/semester',
            templateUrl: "views/semester.html",
            controller: "AppSemesterController",
        })
		// books
			.state('books',
			{
				url: '/books',
				templateUrl: "views/books/index.html",
				controller: "",
			})
			.state('books.list',
			{
				url: '/list',
				templateUrl: "views/books/list.html",
				controller: "AppBooksController",
			})
			.state('books.archive',
			{
				url: '/archive',
				templateUrl: "views/books/archive.html",
				controller: "AppBooksArchiveController",
			})
			.state('books.form',
			{
				url: '/form/:id',
				templateUrl: "views/books/form.html",
				controller: "AppAddEditBooksController",
			})
			.state('books.details',
			{
				url: '/details/:id',
				templateUrl: "views/books/details.html",
				controller: "AppBooksDetailsController",
			})
			.state('books.brrow',
			{
				url: '/borrow',
				templateUrl: "views/books/borrow/form.html",
				controller: "AppBooksBorrowController",
			})
			.state('books.brrowList',
			{
				url: '/borrow/list',
				templateUrl: "views/books/borrow/list.html",
				controller: "AppBooksBorrowListController",
			})
			.state('books.brrowDetails',
			{
				url: '/borrow/details/:id',
				templateUrl: "views/books/borrow/details.html",
				controller: "AppBooksBorrowDetailsController",
			})
		// end books
		.state('product',
        {
            url: '/product',
            templateUrl: "views/product/index.html",
            controller: "",
        })
		.state('product.list',
        {
            url: '/list',
            templateUrl: "views/product/list.html",
            controller: "AppProductController",
        })
		.state('product.form',
        {
         url: '/form/:id',
            templateUrl: "views/product/form.html",
            controller: "AppAddEditProductController",
        })
		.state('product.stock',
        {
            url: '/stock/:id',
            templateUrl: "views/product/stock.html",
            controller: "AppProductStockController",
        })
		
		.state('units',
        {
            url: '/units',
            templateUrl: "views/units.html",
            controller: "AppUnitsController",
        })
		.state('signUp',
        {
            url: '/signup',
            templateUrl: "views/signup.html",
            controller: "AppSignUpController",
        })
		.state('subject',
        {
            url: '/subject',
            templateUrl: "views/subject.html",
            controller: "AppSubjectController",
        })
		.state('type',
        {
            url: '/type',
            templateUrl: "views/type.html",
            controller: "AppTypeController",
        })
		.state('schoolYear',
        {
            url: '/schoolyear',
            templateUrl: "views/schoolyear.html",
            controller: "AppSchoolYearController",
        })
		.state('userType',
        {
            url: '/usertype',
            templateUrl: "views/user_type.html",
            controller: "AppUserTypeController",
        })
		.state('Pages',
        {
            url: '/pages',
            templateUrl: "views/pages.html",
            controller: "AppPagesController",
        })
		//example
		.state('Example1',
        {
            url: '/example1',
            templateUrl: "views/example/example1.html",
            controller: "AppExample1Controller",
        })
		//order 
			.state('orderStatus',
			{
				url: '/orderStatus',
				templateUrl: "views/orderStatus.html",
				controller: "AppOrderStatusController",
			})
			.state('order',
			{
				url: '/order',
				templateUrl: "views/order/index.html",
				controller: "",
			})
			.state('order.list',
			{
				url: '/list',
				templateUrl: "views/order/list.html",
				controller: "AppOrderController",
			})
			.state('order.details',
			{
				url: '/details/:id',
				templateUrl: "views/order/details.html",
				controller: "AppOrderDetailsController",
			})
			//report 
					.state('order.reportDaily',
					{
						url: '/report/daily',
						templateUrl: "views/order/report/daily.html",
						controller: "AppOrderReportDailyController",
					})
					.state('order.reportMonthly',
					{
						url: '/report/monthly',
						templateUrl: "views/order/report/monthly.html",
						controller: "AppOrderReportMonthController",
					})
					.state('order.reportYearly',
					{
						url: '/report/yearly',
						templateUrl: "views/order/report/yearly.html",
						controller: "AppOrderReportYearController",
					})
					.state('order.reportSpecific',
					{
						url: '/report/specific',
						templateUrl: "views/order/report/specificDate.html",
						controller: "AppOrderReportSpecificController",
					})
			//end report 
		// end order
		.state('status',
		{
			url: '/status',
			templateUrl: "views/status.html",
			controller: "AppStatusController",
		})
		// end order
		.state('setting',
		{
			url: '/setting',
			templateUrl: "views/setting.html",
			controller: "AppSettingController",
		})
		// transaction
		.state('transaction',
		{
			url: '/transaction',
			templateUrl: "views/transaction/index.html",
			controller: "AppSettingController",
		})
		.state('transaction.form',
		{
			url: '/form',
			templateUrl: "views/transaction/form.html",
			controller: "AppSettingController",
		})
		
		
}]);
app.config(['growlProvider', function(growlProvider) {
  growlProvider.globalTimeToLive(5000);
}]);