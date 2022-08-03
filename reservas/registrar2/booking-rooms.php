						<div class="row">
							<?php 
							if($booking->getRegRooms()->rowCount()>$_GET['rooms']):
								$max=$booking->getRegRooms()->rowCount();
							?>
							<script type="text/javascript">
								history.pushState(null,null,'<?php echo '?booking-id='.$_GET["booking-id"].'&rooms='.$max; ?>');
								location.reload();
							</script>
							<?php
							else:
								$max=$_GET['rooms'];
							endif;
								

	        					$q=$booking->getRegRooms();
	        					for($i=0;$i<$max;$i++):
	        				?>

		        			<div class="col-6 padd">
			        			<div class="card card-room">
			        				<div class="card-header">
			        					<?php if($_GET['rooms']!=1):?>
			        					<span onclick="removeRoom(this.parentElement.parentElement.parentElement,<?php echo $i; ?>);" class="close">&times;</span>
			        					<?php endif;?>
			        					<strong class="card-title"><i class="fa fa-bed"></i> Información de la habitación (<?php echo ($i+1);?>)</strong>
			        				</div>
			        				<?php 
			        				$aux=$q->fetch();

			        				if(isset($aux['id_registro_habitacion'])):
			        					$regRoom=$booking->getRegRoom($aux['id_registro_habitacion']);
			        				?>
			        				<input id="room-<?php echo $i; ?>" type="text" value="<?php echo $aux['id_registro_habitacion']; ?>" hidden>

			        				<div class="card-body">
			        					<strong><i class="fa fa-bed"></i> Habitación: </strong>
			        					<label><?php echo $regRoom['numero_habitacion'];?></label>
			        					<br>
			        					<strong><i class="fa fa-group"></i> Cantidad de huespedes: </strong>
			        					<label><?php echo setValueToString($regRoom['cantidad_huespedes']);?></label>
			        					<br>
			        					<strong><i class="fa fa-dollar"></i> Tarifa: </strong>
			        					<label><?php echo $regRoom['valor_ocupacion'];?></label>
			        					<p></p>
			        				<?php
			        					endif;
			        				?>
			        				<button type="button" class="btn btn-block btn-register btn-card-room" onclick="setIdRoom(<?php echo $i.','.(isset($aux['id_registro_habitacion'])?$aux['id_registro_habitacion']:"");?>); showModal('room-modal');">
			        					<?php echo (isset($aux['id_registro_habitacion'])?"Editar":"Configurar"); ?>
			        				</button>
			        				<p></p>
			        				<?php
			        					if(isset($aux['id_registro_habitacion'])):
			        					$clients=$booking->getRegClients($aux['id_registro_habitacion']);
			        				
			        					//if($clients->rowCount())
			        				?>
			        					<table>
			        						<tr>
			        							<th>N°</th>
			        							<th>Huesped</th>
			        							<th></th>
			        						</tr>
			        						<?php
			        						$v=1;
			        						foreach ($clients as $key):
			        						?>
			        				 		<tr>
			        				 			<td><?php echo $v++; ?></td>
			        				 			<td><?php echo $key['nombres'];?></td>
			        				 			<td><button class="btn btn-block" onclick="console.log(<?php echo $key['id_persona']; ?>);">Editar</button></td>
			        				 		</tr>
			        				 		<?php 
			        				 		endforeach;

			        				 		for ($j=$clients->rowCount(); $j < setValueToString($regRoom['cantidad_huespedes'])[0]; $j++): 
			        				 		?>
			        				 		<tr>
			        				 			<td><?php echo ($j+1); ?></td>
			        				 			<td><button class="btn btn-block btn-config-client" onclick="setIdClient(<?php echo $aux['id_registro_habitacion']; ?>); showModal('client-modal');">Configurar huesped</button></td>
			        				 			<td></td>
			        				 		</tr>
			        				 		<?php
			        				 		endfor;
			        				 		;?>
			        					</table>
			        				</div>
			        			<?php endif;?>
			        			</div>
		        			</div>
	        				<?php endfor;?>
		        		</div>
		        		<?php 
		        		function setValueToString($value){
		        			switch($value){
								case 'S':
									return '1 (Sencilla)';
								case 'P':
									return '2 (Pareja)';

								case 'D':
									return '2 (Doble)';

								case 'T':
									return '3 (Triple)';

								case 'TS':
									return '4 (Triple con sofacama)';
							}
						} 
						?>