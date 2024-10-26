<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Registrar estado partes del Vehiculo"
    close-on-click-modal
    width="60%"
  >
    <form action>
      <br />
      <div class="card">
        <div class="card-body">
          <el-tabs :tab-position="tabPosition">
            <el-tab-pane label="Principal">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Placa</label>
                  <el-input placeholder></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Kilometraje</label>
                  <el-input placeholder></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Color</label>
                  <el-input placeholder></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Año</label>
                  <el-input placeholder></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Chasis/VIN</label>
                  <el-input placeholder="Ingrese"></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Vencimiento SOAT</label>
                  <el-input placeholder type="date"></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Vencimiento Revision Tec</label>
                  <el-input placeholder type="date"></el-input>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Certificacion Anual</label>
                  <el-input placeholder></el-input>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Accesorios Externos">
              <div class="row">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Faros Delanteros</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Luces direccionales delanteras</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Luces direccionasles posteriores</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Luces de peligro</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Brazo plumilla limpia parabrizas</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Tapa gasolina</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Antena Radio</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Accesorios Externos 2">
              <div class="row">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Espejos laterales</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Manijas de prueba</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Alarma</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Escarpines</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Llanta y aro de repuesto</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Dado segruo de ruedas</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Copa de aro</label>
                    <br />
                    <el-input-number></el-input-number>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <label>Estado</label>
                    <br />
                    <el-radio-group size="small">
                      <el-radio-button label="Bueno"></el-radio-button>
                      <el-radio-button label="Regular"></el-radio-button>
                      <el-radio-button label="Malo"></el-radio-button>
                    </el-radio-group>
                  </div>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Accesorios Internos">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Ceniceros</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Espejo retrovisor interno</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Auto radio</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Alfombra de protección</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Pisos de jebe</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Posa vaso</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Llave de vehiculo</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Herramientas">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Extintor</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Gata y palanca</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estuche de herramientas</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Documentos del Vehiculo">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Tarjeta de Propiedad</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Cuaderno de bitacora</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Manual de propietario</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Porta documentos</label>
                  <br />
                  <el-input-number></el-input-number>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <label>Estado</label>
                  <br />
                  <el-radio-group size="small">
                    <el-radio-button label="Bueno"></el-radio-button>
                    <el-radio-button label="Regular"></el-radio-button>
                    <el-radio-button label="Malo"></el-radio-button>
                  </el-radio-group>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Autorizaciones">
              <div class="row">
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Autorizo el ingreso de mi vehiculo a la cochera interna del taller</label>
                  <el-checkbox>Aceptar</el-checkbox>
                </div>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Autorizo enviar mi vehiculo para trabajos de terceros en talleres de su elección</label>
                  <el-checkbox>Aceptar</el-checkbox>
                </div>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Declaro que no existen elementos de valor dentro del vehiculo</label>
                  <el-checkbox>Aceptar</el-checkbox>
                </div>
                <div
                  class="col-12 d-flex flex-column justify-content-center align-items-center mt-2"
                >
                  <label
                    class="text-center"
                  >Acepto retirar mi vehiculo en un máximo de 3 días, luego de finalizado el servicio; caso contrario asumiré un costo de S/ 7.00 diarios de cochera (interna y/o externa)</label>
                  <el-checkbox>Aceptar</el-checkbox>
                </div>
              </div>
            </el-tab-pane>
            <el-tab-pane label="Gasolina Observaciones">
              <div class="row">
                <div class="col-12">
                  <label>Gasolina</label>
                  <div class="block">
                    <el-slider v-model="value" show-input></el-slider>
                  </div>
                </div>
                <div class="col-12">
                  <label>Observaciones</label>
                  <el-input type="textarea" :rows="2" placeholder="Please input" v-model="textarea"></el-input>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
        </div>
      </div>
      <div class="form-actions text-right mt-4">
        <el-button @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit">Guardar</el-button>
      </div>
      <br />
    </form>
  </el-dialog>
</template>
<script>
export default {
  props: ["showDialog"],
  data() {
    return {
      tabPosition: "left",
      value: 0,
      textarea: ""
    };
  },
  methods: {
    open() {},
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>