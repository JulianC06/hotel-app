					<div class="card">
	        			<div class="card-header">
	        				<strong class="card-title">Titular</strong>
	        			</div>

	        			<div class="card-selector">
	        				<div id="select-holder" class="col-12">
	        					<div class="row">
	        						<div class="col-6 padd">
	        							<button type="button" class="btn btn-block btn-header" onclick="toggleHolder(this);">Persona natural</button>
	        						</div>

	        						<div class="col-6 padd">
	        							<button type="button" class="btn btn-block btn-header" onclick="toggleHolder(this);">Empresa</button>
	        						</div>
	        					</div>
	        				</div>
	        			</div>

	        			<div id="search-holder" class="card-search" hidden>
	        				<div class="row">
								<div class="col-4 padd">
									<div class="form-group">
										<label class="form-control-label">Busqueda por número de documento</label>
										<div class="input-group">
											<div class="input-group-icon">
												<i class="fa fa-search"></i>
											</div>
											<input class="form-control" type="text" placeholder="Documento" maxlength="15" onkeypress="searchEvent(event,this);" onkeydown="$(this).mask('000000000000');">
											<button type="button" onclick="searchPerson(this.previousElementSibling);"><i class="fa fa-search"></i></button>
										</div>
										<small class="form-text text-muted">ej. 102055214</small>
									</div>
								</div>
							</div>
						</div>
	        			
	        			<form onsubmit="insertHolder(this); return false;">
	        				<input type="text" name="type" value="P" hidden>
	        				<input id="holder-id" type="text" name="holder-id" hidden>

	        				<div id="person-holder" hidden>
			        			<div class="card-body">
			        				<div class="row">
			        					<div class="col-6 padd">
			        						<div class="form-group">
				        						<label class="form-control-label">Nombres</label>
												<div class="input-group">
													<div class="input-group-icon">
														<i class="fa fa-user"></i>
													</div>
													<input type="text" class="form-control" onchange="" required placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2">
												</div>
												<small class="form-text text-muted">ej. JUAN JOSÉ</small>
											</div>
			        					</div>

			        					<div class="col-6 padd">
			        						<div class="form-group">
				        						<label class="form-control-label">Apellidos</label>
												<div class="input-group">
													<div class="input-group-icon">
														<i class="fa fa-user"></i>
													</div>
													<input type="text" class="form-control" required placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2">
												</div>
												<small class="form-text text-muted">ej. PÉREZ LÓPEZ</small>
											</div>
			        					</div>
			        				</div>

			        				<div class="row">
			        					<div class="col-6 padd">
			        						<div class="form-group">
				        						<label class="form-control-label">Teléfono</label>
												<div class="input-group">
													<div class="input-group-icon">
														<i class="fa fa-user"></i>
													</div>
													<input type="text" class="form-control" onchange="" required placeholder="Teléfono" onkeydown="$(this).mask('000 000 0000');">
												</div>
												<small class="form-text text-muted">ej. JUAN JOSÉ</small>
											</div>
			        					</div>

			        					<div class="col-6 padd">
			        						<div class="form-group">
				        						<label class="form-control-label">Correo</label>
												<div class="input-group">
													<div class="input-group-icon">
														<i class="fa fa-user"></i>
													</div>
													<input type="email" class="form-control" onchange="" placeholder="Correo">
												</div>
												<small class="form-text text-muted">ej. PÉREZ LÓPEZ</small>
											</div>
			        					</div>
			        				</div>

			        				<div class="switch-group">
				        				<label class="switch switch-container">
				        					<input id="holder-stay" name="holder-stay" type="checkbox" onchange="toggleStayLabel(this);">
				        					<span class="slider slider-gray round green"></span>
				        				</label>
				        				<label id="holder-stay-label" class="switch-label">El titular no se hospedará.</label>
				        			</div>
			        			</div>

			        			<button class="btn btn-block btn-register" style="margin-top: 20px;">
									<i class="fa fa-check"></i>
									<span>Listo</span>
								</button>
			        		</div>
		        		</form>

		        		<form onsubmit="insertHolder(this); return false;">
	        				<input type="text" name="type" value="B" hidden>

		        			<div id="bizz-holder"  hidden>
			        			<div class="card-body">
			        				<div class="row">
			        					<div class="col-12 padd">
			        						<div class="form-group">
						        				<label class="form-control-label">Empresa</label>
												<div class="input-group">
													<div class="input-group-icon">
														<i class="fa fa-bank"></i>
													</div>

													<select class="form-control" name="holder-id" onchange="showBizzInfo(this);">
														<option value="">Seleccione una empresa</option>
														<?php $consult->enterpriseList(); ?>
													</select>
													<button type="button" onclick="showModal('bizz-modal');" class="btn-circle"><i class="fa fa-plus"></i></button>
												</div>
											</div>
			        					</div>
			        				</div>

			        				<div id="bizz-data" hidden>
			        					<div class="row">
			        						<div class="col-3 padd">
			        							<div class="form-group">
							        				<label class="form-control-label">Telefono</label>
													<div class="input-group">
														<div class="input-group-icon">
															<i class="fa fa-phone"></i>
														</div>
														<input type="text" class="form-control">
													</div>
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
	        		</div>