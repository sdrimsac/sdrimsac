<template>
  <!-- <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Registrar estado partes del Vehiculo"
    close-on-click-modal
    width="60%"
  >
    <form action>
      <br /> -->
      <div class="">
        <div class="row">
          <el-tabs
            v-model="activePanelVehiculo"
            @tab-click="handleClickVehicle"
            tab-position="left"
            :style="`height: ${height}px`"
          >
            <el-tab-pane class="mb-3" name="principal">
              <span slot="label">Principal</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Chasis/VIN</label>
                  <el-input v-model="vehiculo.chasis"></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Vencimiento SOAT</label>
                  <el-date-picker
                    v-model="vehiculo.date_soat_due"
                    type="date"
                    placeholder="Seleccione una fecha"
                    value-format="yyyy-MM-dd"
                    format="yyyy-MM-dd"
                    style="width: 100%"
                  ></el-date-picker>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Vencimiento Revision Tec</label>
                  <el-date-picker
                    v-model="vehiculo.date_check_due"
                    type="date"
                    placeholder="Seleccione una fecha"
                    value-format="yyyy-MM-dd"
                    format="yyyy-MM-dd"
                    style="width: 100%"
                  ></el-date-picker>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Certificacion Anual</label>
                  <el-input v-model="vehiculo.certificate"></el-input>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Accesorios Externos">
              <span slot="label">Accesorios Externos</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Faros Delanteros</label>
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantiy_front_lights"
                    :min="0.00"
                    :max="6"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_front_lights" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Luces direccionales delanteras</label>
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_directional_lights_front"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_directional_lights_front" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Luces direccionasles posteriores</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_directional_lights_back"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_directional_lights_back" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Luces de peligro</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_hazard_lights"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_hazard_lights" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Brazo plumilla limpia parabrizas</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_wiper_washer_arm"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_wiper_washer_arm" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Tapa gasolina</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_gasoil_cap"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_gasoil_cap" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Antena Radio</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_radio_antenna"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_radio_antenna" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Accesorios Externos 2">
              <span slot="label">Accesorios Externos 2</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Espejos laterales</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_side_mirrors"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_side_mirrors" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Manijas de prueba</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_test_handles"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_test_handles" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Alarma</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_alarm"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_alarm" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Escarpines</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_booties"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_booties" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Llanta y aro de repuesto</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_spare_tire" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_spare_tire" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Dado seguro de ruedas</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_wheel_nut" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_wheel_nut" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Copa de aro</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_wheel_cup" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_wheel_cup" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Accesorios Internos">
              <span slot="label">Accesorios Internos</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Ceniceros</label>
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_ashtray"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_ashtray" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Espejo retrovisor interno</label>
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_internal_rearview_mirror"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_internal_rearview_mirror" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Auto radio</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_car_radio"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_car_radio" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Alfombra de protección</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_protection_mat"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_protection_mat" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Pisos de jebe</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_rubber_floors"
                    :min="0.00"
                    :max="6"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_rubber_floors" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Posa vaso</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_cup_holder"
                    :min="0.00"
                    :max="4"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_cup_holder" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Llave de vehiculo</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_vehicle_key"
                    :min="0.00"
                    :max="2"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_vehicle_key" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Herramientas">
              <span slot="label">Herramientas</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Extintor</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_extinguisher"
                    :min="0.00"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_extinguisher" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Gata y palanca</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_jack_lever" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_jack_lever" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estuche de herramientas</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_toolkit" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_toolkit" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Documentos del Vehiculo">
              <span slot="label">Documentos del Vehiculo</span>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Tarjeta de Propiedad</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_property_card"
                    :min="0.00"
                    :max="1"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_property_card" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Cuaderno de bitacora</label>
                  <br />
                  <el-input-number class="w-100" v-model="vehiculo.quantity_logbook" :min="0.00"></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_logbook" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Manual de propietario</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_owner_manual"
                    :min="0.00"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_owner_manual" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Porta documentos</label>
                  <br />
                  <el-input-number
                    class="w-100"
                    v-model="vehiculo.quantity_document_holder"
                    :min="0.00"
                  ></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label class="w-100">Estado</label>
                  <el-radio-group v-model="vehiculo.state_document_holder" size="mini">
                    <el-radio-button
                      class=""
                      v-for="(state, idx) in states"
                      :key="idx"
                      :label="state.name"
                    ></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Autorizaciones">
              <span slot="label">Autorizaciones</span>
              <div class="row">
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Autorizo el ingreso de mi vehiculo a la cochera interna del taller</label>
                  <el-checkbox v-model="vehiculo.auth_drive">Aceptar</el-checkbox>
                </div>
                <el-divider></el-divider>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Autorizo enviar mi vehiculo para trabajos de terceros en talleres de su elección</label>
                  <el-checkbox v-model="vehiculo.move_on">Aceptar</el-checkbox>
                </div>
                <el-divider></el-divider>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Declaro que no existen elementos de valor dentro del vehiculo</label>
                  <el-checkbox v-model="vehiculo.no_value_things">Aceptar</el-checkbox>
                </div>
                <el-divider></el-divider>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Acepto retirar mi vehiculo en un máximo de 3 días, luego de finalizado el servicio; caso contrario asumiré un costo de S/ 7.00 diarios de cochera (interna y/o externa)</label>
                  <el-checkbox v-model="vehiculo.cost_for_days">Aceptar</el-checkbox>
                </div>
                <el-divider></el-divider>
              </div>
            </el-tab-pane>
            <el-tab-pane class="mb-3" name="Gasolina Observaciones">
              <span slot="label">Gasolina Observaciones</span>
              <div class="row">
                <div class="col-12">
                  <label>Gasolina</label>
                  <div class="block">
                    <el-slider
                      class="p-2"
                      v-model="vehiculo.gasoline_level"
                      :step="1"
                      :min="0"
                      :max="100"
                      show-stops
                    ></el-slider>
                  </div>
                </div>
                <div class="col-12">
                  <label>Observaciones</label>
                  <el-input type="textarea" rows="4" v-model="vehiculo.observations"></el-input>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
        </div>
      </div>
      <!-- <div class="form-actions text-right mt-4">
        <el-button @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit">Guardar</el-button>
      </div> -->
      <!-- <br />
    </form>
  </el-dialog> -->
</template>
<script>
export default {
  props: ["vehiculo"],
  data() {
    return {
      height: 400,
      states: [
        { id: 1, name: "Bueno" },
        { id: 2, name: "Regular" },
        { id: 3, name: "Malo" }
      ],
      activePanelVehiculo: "principal"
    };
  },
  methods: {
    handleClickVehicle(tab, event) {
      this.activePanelVehiculo = tab.name;
      // if (this.activePanelVehicle == "accesories") {
      //     this.height = 500;
      // } else {
      //     this.height = 200;
      // }
    },

    open() {},
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>