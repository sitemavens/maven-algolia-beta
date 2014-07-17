var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaClient',['MAConfig', function(MAConfig){
		console.log('AlgoliaClient:init');
		var algoliaClient = {};
		
		algoliaClient = {
			get:function(){
				console.log('AlgoliaClient:get');
				algoliaClient = new AlgoliaSearch( MAConfig.appId, MAConfig.apiKey );
				return algoliaClient;
			}
		};
		
		return algoliaClient;
	
}]);