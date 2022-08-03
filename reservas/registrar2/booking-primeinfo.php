	        		<form onsubmit="insertBooking(this,<?php echo $user->getId();?>); return false;">
	        			<div hidden>
	        				<input type="text" name="holder-id" value="<?php echo $_GET['holder-id'];?>">
	        				<input type="text" name="type" value="<?php echo $_GET['type'];?>">
	        				<input type="text" name="booking-id">
	        			</div>

		        		<div class="card">
		        			<div class="card-header">
	        					<strong class="card-title">Información primaria</strong>
		        			</div>

		        			<div class="card-body">
		        				<div class="row">
		        					<div class="col-3 padd">
		        						<div class="form-group">
					        				<label class="form-control-label">Check in</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-calendar"></i>
												</div>

												<input id="start-date" type="date" class="form-control" onchange="getDays();">
											</div>
										</div>
		        					</div>

		        					<div class="col-3 padd">
		        						<div class="form-group">
					        				<label class="form-control-label">Check out</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-calendar"></i>
												</div>

												<input id="finish-date" type="date" class="form-control" onchange="getDays();">
											</div>
										</div>
		        					</div>

		        					<div class="col-3 padd">
		        						<div class="form-group">
					        				<label class="form-control-label">Cantidad de noches</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-moon-o"></i>
												</div>

												<input id="count-nights" type="number" class="form-control" min="1" value="1" onchange="getDate(this.value,'finish-date','start-date');">
											</div>
										</div>
		        					</div>

		        					<div class="col-3 padd">
		        						<div class="form-group">
					        				<label class="form-control-label">Cantidad de habitaciones</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-moon-o"></i>
												</div>

												<input id="rooms" type="number" class="form-control" min="1" value="1" max="10">
											</div>
										</div>
		        					</div>
		        				</div>
		        			</div>

		        			<button class="btn btn-block btn-register">
								<i class="fa fa-check"></i>
								<span>Listo</span>
							</button>
		        		</div>
	        		</form>
	        		<script type="text/javascript">
	        			getDate(0,'start-date'); 
	        			getDate(1,'finish-date'); 
	        		</script>