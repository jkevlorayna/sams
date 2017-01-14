var MainFolder = 'sams';
var MainFolder = 'sams';
var BasePath = 'core';
var app = angular.module('app', ['ui.router','ui.bootstrap','ngSanitize', 'ui.select','angular-growl','ngCookies','ngAnimate','checklist-model','io-barcode','angular-loading-bar','tableSort','angularFileUpload']);
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
            controller: "AppHomeController",
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
		.state('eventReportCourse',
        {
            url: '/event/details/:Id/report/course',
            templateUrl: "views/event/report/course.html",
            controller: "AppEventDetailsReportCourseController",
        })
		.state('eventReportCourseYear',
        {
            url: '/event/details/:Id/report/course/:CourseId',
            templateUrl: "views/event/report/course-year.html",
            controller: "AppEventDetailsReportCourseYearController",
        })
		.state('eventReportCourseYearSection',
        {
            url: '/event/details/:Id/report/course/:CourseId/:CourseYearId',
            templateUrl: "views/event/report/course-year-section.html",
            controller: "AppEventDetailsReportCourseYearSectionController",
        })
		.state('eventReportOrganization',
        {
            url: '/event/details/:Id/report/organization',
            templateUrl: "views/event/report/organization.html",
            controller: "AppEventDetailsReportOrganizationController",
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
		.state('organization',
        {
            url: '/organization',
            templateUrl: "views/organization.html",
            controller: "AppOrganizationController",
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
		// barcode 
		.state('barcode',
		{
			url: '/barcode/generate',
			templateUrl: "views/barcode/generate.html",
			controller: "AppBarcodeController",
		})
		
}]);
app.config(['growlProvider', function(growlProvider) {
  growlProvider.globalTimeToLive(5000);
}]);