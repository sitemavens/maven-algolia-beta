
var app = angular.module('mavenAlgolia', [
	'ngCookies',
	'ngResource',
	'ngSanitize',
	'ngRoute',
	'ui.bootstrap',
	'mavenAlgolia.controllers',
	'mavenAlgolia.services'
]).config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider) {
		console.log('mavenAlgolia: init');
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

	}]);

angular.module('mavenAlgolia.controllers', ['ngResource']);
angular.module('mavenAlgolia.services', ['ngResource']);
