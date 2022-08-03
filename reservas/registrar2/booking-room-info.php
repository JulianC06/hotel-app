                <form onsubmit="insertRoom(this,<?php echo $_GET['booking-id'];?>); return false;">
                    <div id="room" hidden></div>
                    <input id="room-id" type="text" hidden>
                    
                    <div id="room-values" class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group in-row">
                                        <label class="form-control-label">Numero de huespedes</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-group"></i>
                                            </div>

                                            <select id="room-quantity" class="form-control guests-quantity" onchange="updateRoomTypes(this);" required>
                                                <option value="S">1 (Sencilla)</option>
                                                <option value="P">2 (Pareja)</option>
                                                <option value="D">2 (Doble)</option>
                                                <option value="T">3 (Triple)</option>
                                                <option value="TS">4 (Triple + Sofacama)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group in-row">
                                        <label class="form-control-label">Tipo de habitación</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-bed"></i>
                                            </div>

                                            <select id="room-types" class="form-control room-type" onchange="updateRooms();" required>
                                                <?php $consult->roomQuantityList('S',"'".date("Y-m-d")."'","'".date_format(date_add(date_create(date("Y-m-d")),new DateInterval('P1D')),"Y-m-d")."'"); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group in-row">
                                        <label class="form-control-label">Número de habitación</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-bed"></i>
                                            </div>

                                            <select id="room-numbers" class="form-control room-number" required>
                                                <?php $consult->roomTypeList("1","'".date("Y-m-d")."'","'".date_format(date_add(date_create(date("Y-m-d")),new DateInterval('P1D')),"Y-m-d")."'"); ?>
                                            </select>
                                        </div>
                                    </div>
                                            
                                    <div class="form-group in-row">
                                        <label class="form-control-label">Tarifa de habitación</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-dollar"></i>
                                            </div>

                                            <select id="room-tariffs" class="form-control" onchange="showCustomTariff(this);" required>
                                                <?php $consult->getList('tariff','S','1');?>
                                            </select>
                                        </div>
                                    </div>
                                            
                                    <div id="custom-tariff" class="form-group in-row hideable">
                                        <label class="form-control-label">Tarifa personalizada</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="text" class="form-control" onkeydown="$(this).mask('000.000.000.000.000', {reverse: true});">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button id="room-next-button" class="btn btn-block btn-register">
                            <i class="fa fa-arrow"></i>
                            <span>Listo</span>
                        </button>
                    </div>
                </form>