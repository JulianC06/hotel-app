				<aside class="col-3 padd">
	        		<div class="card">
	        			<div class="card-header">
	        				<strong class="card-title">Resumen</strong>
	        			</div>

	        			<?php if(!isset($_GET['type'])&&!isset($booking)):?>
	        				<div class="card-body">No se ha definido ningún valor</div>
	        			<?php else:?>

	        			<div class="card-body">
	        				<div class="form-group">
	        					<label class="form-control-label">Titular</label>
	        					<div class="input-group">
	        						<input type="text" class="form-control" style="font-size: 12px;" value="<?php echo $holder->getFullName(); ?>" disabled>
	        					</div>
	        				</div>

	        				<div class="form-group">
	        					<label class="form-control-label">Teléfono</label>
	        					<div class="input-group">
	        						<div class="input-group-icon">
	        							<i class="fa fa-phone"></i>
	        						</div>
	        						<input type="text" class="form-control" disabled value="<?php echo $holder->getPhone();?>">
	        					</div>
	        				</div>
	        			</div>

	        			<?php if(isset($_GET['booking-id'])):?>
	        			<div class="card-body">
	        				<div class="form-group">
	        					<label class="form-control-label">Check in</label>
	        					<div class="input-group">
	        						<div class="input-group-icon">
	        							<i class="fa fa-calendar"></i>
	        						</div>
	        						<input id="check-in" type="date" class="form-control" disabled value="<?php echo $booking->getStartDate();?>">
	        					</div>
	        				</div>

	        				<div class="form-group">
	        					<label class="form-control-label">Check out</label>
	        					<div class="input-group">
	        						<div class="input-group-icon">
	        							<i class="fa fa-calendar"></i>
	        						</div>
	        						<input id="check-out" type="date" class="form-control" disabled value="<?php echo $booking->getFinishDate();?>">
	        					</div>
	        				</div>

	        				<div class="form-group">
	        					<label class="form-control-label">Cantidad de noches</label>
	        					<div class="input-group">
	        						<div class="input-group-icon">
	        							<i class="fa fa-moon-o"></i>
	        						</div>
	        						<input id="summ-nights" type="text" class="form-control" disabled>
	        					</div>
	        				</div>

	        				<div class="form-group">
	        					<label class="form-control-label">Cantidad de habitaciones</label>
	        					<div class="input-group">
	        						<div class="input-group-icon">
	        							<i class="fa fa-bed"></i>
	        						</div>
	        						<input type="text" class="form-control" disabled value="<?php echo $_GET['rooms']?>">
	        					</div>
	        				</div>
	        			</div>
	        			<script type="text/javascript">
	        				 getDays("check-in","check-out","summ-nights");
	        			</script>
	        			<?php endif;?>

	        			<?php endif;?>
	        		</div>
	        		<div class="col-12">
	        			<?php if(isset($_GET['booking-id'])): ?>
	        			<button id="delete-booking" class="btn btn-block btn-red" onclick="cancelBooking(<?php echo $_GET['booking-id']; ?>);"><i class="fa fa-bin"></i> Cancelar y eliminar</button>
	        			<?php endif; ?>
	        		</div>
	        	</aside>