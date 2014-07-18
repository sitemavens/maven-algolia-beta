var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaHelper', ['$q','$rootScope', 'AlgoliaClient', 'MAConfig', function($q,$rootScope, AlgoliaClient, MAConfig) {

		var algoliaHelperInstance = {};
		var helper = false;
		
		var searchCallback = function(success, content) {
			algoliaHelperInstance.log('AlgoliaHelper:searchCallback');
			
			algoliaHelperInstance.page = content.page;
			algoliaHelperInstance.nbPages = content.nbPages;
			algoliaHelperInstance.hitsPerPage = content.hitsPerPage;
			algoliaHelperInstance.nbHits = content.nbHits;
			$rootScope.$broadcast('algoliaResultUpdated', content);
			if(!$rootScope.$$phase) {
				$rootScope.$apply();
			}
		};
		
		
		
		algoliaHelperInstance = {
			indexName: '',
			rangeSize: 2, // Define how many pages links should be showed before and after the current page
			page: 0,
			nbPages: 0,
			hitsPerPage: 0,
			nbHits: 0,
			filters: { numericFilters: [] },
			options: {
				hitsPerPage: 12,
				facets: '',
				numericFilters: ''
			},
			log: function( logTxt ){
				if( this.debug() && angular.isDefined(console) ){
					console.log( logTxt );
				}
			},
			debug: function(){
				return MAConfig.debug;
			},
			
			get: function() {
				if (!helper) {
					helper = new AlgoliaSearchHelper(AlgoliaClient.get(), this.indexName);
				}

				return helper;
			},
			search: function(value, options) {
				algoliaHelperInstance.log('AlgoliaHelper:Instance:search');
				if (!value) {
					value = '';
				}

				if (options) {
					if (typeof (options.indexName) !== "undefined") {
						this.indexName = options.indexName;
					}

					if (typeof (options.facets) !== "undefined") {
						this.options.facets = options.facets;
					}

					if (typeof (options.numericFilters) !== "undefined") {
						this.options.numericFilters = options.numericFilters;
					}
				}
				this.get().search(value, searchCallback, this.options);
				
				//return deferred.promise;

			},
			setRangeSize: function(size){
				if( size ){
					this.rangeSize = size;
				}else{
					this.rangeSize = 2;
				}
			},
			hidePreviousPage: function() {
				return (this.page < 1);
			},

			showPreviousDots: function() {
				return (this.page > this.rangeSize);
			},

			hideNextPage: function() {
				return (this.page + 1 >= this.nbPages || this.nbPages === 0 || this.nbPages === 1);
			},

			showNextDots: function() {
				return (this.page < this.nbPages - this.rangeSize && this.nbPages > (this.rangeSize * 2) + 1);
			},

			getPaginationRange: function() {
				var ps = [];
				var start, end, current;

				start = this.page;
				current = this.page;
				if (start > this.rangeSize - 1) {
					start = this.page - this.rangeSize;
					end = current + this.rangeSize + 1;
					if (end > this.nbPages) {
						end = this.nbPages;
					}
				} else {
					start = 0;
					end = (this.rangeSize * 2) + 1;
					if (end > this.nbPages) {
						end = this.nbPages;
					}
				}

				for (var i = start; i < end; i++) {
					ps.push(i);
				}

				return ps;
			},
			displayPageNum: function(page) {
				// increment the page in 1 since algolia starts in 0
				return page + 1;
			},
			displayingResultsFrom: function() {
				return (this.hitsPerPage < this.nbHits ) ? ( (this.page === 0) ? 0 : this.hitsPerPage * this.page ) : this.nbHits;
			},
			displayingResultsTo: function() {
				return (this.hitsPerPage < this.nbHits ) ? ( ( (this.hitsPerPage * this.page) + this.hitsPerPage) > this.nbHits ? this.nbHits : ( (this.hitsPerPage * this.page) + this.hitsPerPage) ) : this.nbHits;
			},
			totalResults: function() {
				return this.nbHits;
			},
			clearNumericFilters: function() {
				this.options.numericFilters = '';
				this.filters.numericFilters = new Array();
			},
			prepareNumericFilters: function(){
				var _this = this;
				if( angular.isArray( this.filters.numericFilters ) ){
					var where = '';
					var separator = ',';
					// if numerics filters already exists the query should starts with ","(comma)
					var querySeparator = ( angular.isDefined(this.options) && angular.isDefined(this.options.numericFilters) && this.options.numericFilters) ? ',' : '';
					angular.forEach(this.filters.numericFilters, function(value, key) {
						// If it is the first filter we would use the query separator
						// after first filter all queries should have a ","(comma) as separator
						where = (key === 0) ? querySeparator : separator;
						// "OR" comparison should be closed by brackets, so open it here
						if( angular.isDefined(value.relation) && value.relation === 'OR' ){
							where += '(';
						}
						if( angular.isDefined(value.query) && angular.isArray(value.query) ){
							angular.forEach(value.query, function(queryValue, queryKey) {
								// Don't add the separator if it is the first item in the query
								if( queryKey > 0 ){
									where += separator;
								}
								where += queryValue.field;

								if( angular.isDefined(queryValue.compare) ){
									switch (queryValue.compare){
										case 'BEETWEEN':
											where += ':';
											break;
										default:
											where += queryValue.compare;
											break;
									}
								}
								
								if( angular.isArray(queryValue.value) ){
									switch (queryValue.compare){
										case 'BEETWEEN':
											where += queryValue.value[0] + ' to ' + queryValue.value[1];
											break;
										default:
											//use the first item to avoid errors if the : was not set as logical operator
											where += queryValue.value[0];
											break;
									}
								}else{
									where += queryValue.value;
								}
							});
						}
						// "OR" comparison should be closed by brackets, so close it here
						if( angular.isDefined(value.relation) && value.relation === 'OR' ){
							where += ')';
						}
					});
				}
				if( where ){
					this.options.numericFilters += where;
				}
				this.log(this.options.numericFilters);
			}
		};

		return algoliaHelperInstance;

	}]);