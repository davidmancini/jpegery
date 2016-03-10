app.controller('MyCtrl', ['$scope', 'Upload', function ($scope, Upload) {
	$scope.submit = function() {
		if($scope.form.file.$valid && $scope.file) {
			$scope.upload($scope.file, $scope.caption);
		}
	};

	$scope.upload = function(file, caption) {
		Upload.upload({
			url: 'image-upload.php',
			method: 'POST',
			data: {file: file, text: text}
		}).then(function(result) {

			console.log('Success ' + result.config.data.file.name + ' uploaded. Response: ' + result.data);
			console.log(result.data);
		}, function(result){
			console.log('Error Status: ');
		}, function(evt){
			var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
			console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
		});
	};
}]);
