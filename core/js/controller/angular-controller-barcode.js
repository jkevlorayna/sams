
app.controller('AppBarcodeController', function ($scope, $http, $q, $location, svcCategory,growl,$uibModal) {
    

		  
	$scope.randomCode = [];		
	$scope.formData = {  }
	$scope.save = function () {
		
		for (i = 0; i < $scope.formData.Number; i++) { 
			$scope.random = Math.floor(Math.random()*9000000) + 1000000;
			$scope.randomCode.push({Code:$scope.random});	
		}
		
			
    }

	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});
