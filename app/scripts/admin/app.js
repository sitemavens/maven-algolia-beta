
angular.module('phApp', [
	'ngCookies',
	'ngResource',
	'ngSanitize',
	'ngRoute',
	'ui.bootstrap'
]).config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider) {

		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

		$routeProvider
			.when('/', {
				templateUrl: GFSeoMk.viewsUrl + 'main.php',
				controller: 'MainCtrl',
				resolve: {
					FormsList: ['FormsLoader',function(FormsLoader) {
						return FormsLoader();
					}],
					MetricsList:['MetricsLoader', function (MetricsLoader){
						return MetricsLoader();
					}]
				}
			})
			
			.otherwise({
				redirectTo: '/'
			});
	}]);
 