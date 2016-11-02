
app.controller('AppHomeController', function ($scope, $http, $q, $filter, svcMember,svcMemberType,growl,$uibModal,$stateParams,svcSemester,svcSchoolYear) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;

		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
		
		$q.all([svcSemester.list('',0,0),svcSchoolYear.list('',0,0)]).then(function(r){
		$scope.SemesterList = r[0].Results;
		$scope.SchoolYearList = r[1].Results;
		
		$scope.CurrentSemester = $filter('filter')($scope.SemesterList, {Current:1})[0];
		$scope.CurrentSchoolYear = $filter('filter')($scope.SchoolYearList, {Current:1})[0];
		
		$scope.Semester = $scope.CurrentSemester.Semester;
		$scope.SchoolYear = $scope.CurrentSchoolYear.Id


		
			
			$scope.loadMemberType = function () {
				svcMemberType.list('',0,0).then(function (r) {
					$scope.memberTypeList = r.Results;
					$scope.TotalMember = 0;
					angular.forEach($scope.memberTypeList,function(rr){
						svcMember.list($scope.searchText,0,0,rr.Id).then(function (rMember) {
							 rr.MemberCount = rMember.Count;
							$scope.TotalMember += rMember.Count;
						})
					})
				})
			}
			$scope.loadMemberType();
	
	})
		


});

