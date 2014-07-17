var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaHelper', ['$q','$rootScope',  'AlgoliaClient', function($q,$rootScope, AlgoliaClient) {

		var algoliaHelperInstance = {};
		var helper = false;
		
		var searchCallback = function(success, content) {
			algoliaHelperInstance.page = content.page;
			algoliaHelperInstance.nbPages = content.nbPages;
			algoliaHelperInstance.hitsPerPage = content.hitsPerPage;
			algoliaHelperInstance.nbHits = content.nbHits;
			$rootScope.$broadcast('algoliaResultUpdated', content);
			
			$rootScope.$apply();

		};
		
		
		
		algoliaHelperInstance = {
			indexName: '',
			rangeSize: 2, // Define how many pages links should be showed before and after the current page
			page: 0,
			nbPages: 0,
			hitsPerPage: 0,
			nbHits: 0,
			options: {
				hitsPerPage: 12,
				facets: '',
				numericFilters: ''
			},
			
			get: function() {
				if (!helper) {
					helper = new AlgoliaSearchHelper(AlgoliaClient.get(), this.indexName);
				}

				return helper;
			},
			search: function(value, options) {
				
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
			}
		};

		return algoliaHelperInstance;

	}]);