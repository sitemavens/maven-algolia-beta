var app = angular.module('mavenAlgolia.services');

app.constant('MAConfig', {
	apiKey: MASearchConfig.algoliaApiKey,
	appId: MASearchConfig.algoliaAppId,
	debug: angular.isDefined( MASearchConfig.debug ) ? MASearchConfig.debug : false
});