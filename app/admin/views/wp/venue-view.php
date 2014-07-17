
<div ng-controller="VenueCtrl">	
	<input type="hidden" name="mvn[venue][id]" ng-value="venue.id" />

	<tabset>
		<tab heading="General">
			<div class="form-horizontal" style="margin:15px 0;">
				<div class="form-group"  >
					<label for="" class="col-sm-2 control-label">Phone:</label>
					<div class="col-sm-5">
						<div class="input-group">
							<input class="form-control" type="text" ng-model="venue.phone" name="mvn[venue][phone]"  />
						</div>
					</div>
				</div>
				 
			</div>
		</tab>
	</tabset>


	<div class="alert alert-danger" ng-show="post.$invalid">
		<span ng-show="post.$error.required">Required elements</span>
		<span ng-show="post.$error.invalid">Invalid elements</span>
	</div>


</div>
