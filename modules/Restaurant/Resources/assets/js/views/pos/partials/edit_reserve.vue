<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        width="50%"
        title="Editar reserva"
        v-loading="loading"
    >
        <template v-if="roomEdit">
            <div class="row m-2">
                <div class="col-6">
                    <label for="days">Fecha de reserva</label>
                    <el-date-picker
                        v-model="roomEdit.checkin_date"
                        type="date"
                        @change="changeTable"
                        placeholder="Fecha de ingreso"
                        size="small"
                        style="width: 100%;"
                        value-format="yyyy-MM-dd"
                        :picker-options="{
                            defaultDate: Date.now('America/Lima'),
                            disabledDate: time => {
                                return time.getTime() < Date.now() - 8.64e7;
                            }
                        }"
                    ></el-date-picker>
                </div>
                <div class="col-6">
                    <label for="days">Hora de reserva</label>
                    <el-time-picker
                        v-model="roomEdit.checkin_time"
                        size="small"
                        placeholder="Hora de ingreso"
                        style="width: 100%;"
                        value-format="HH:mm:ss"
                        @change="changeTable"
                        :format="'hh:mm A'"
                        :picker-options="{
                            format: 'hh:mm A'
                        }"
                        timezone="America/Lima"
                    ></el-time-picker>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <label for="name">Torre</label>
                    <el-select
                        v-model="roomEdit.tower_id"
                        @change="filterFloorsByTower(roomEdit.tower_id)"
                    >
                        <el-option
                            v-for="option in towers"
                            :key="option.id"
                            :label="option.name"
                            :value="option.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <label for="name">Piso</label>
                    <el-select
                        v-model="roomEdit.floor_id"
                        @change="filterTablesByFloor(roomEdit.floor_id)"
                    >
                        <el-option
                            v-for="option in floors"
                            :key="option.id"
                            :label="option.name"
                            :value="option.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <label for="name">Habitación</label>
                    <el-select
                        @change="changeTable"
                        v-model="roomEdit.table_id"
                    >
                        <el-option
                            v-for="option in tables"
                            :key="option.id"
                            :label="option.number"
                            :value="option.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <label for="duration">Días</label>
                    <el-input
                        type="number"
                        @input="changeTable"
                        v-model="roomEdit.duration"
                        placeholder="Duración"
                        size="small"
                        step="1"
                        style="width: 100%;"
                    ></el-input>
                </div>
            </div>
        </template>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="editReserveDate(roomEdit.id)"
                >Agregar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog","roomEdit"],
    data() {
        return {
            loading:false,
            all_tables: [],
            all_floors: [],
            towers: [],
            floors: [],
            tables: [],
        };
    },
    methods: {
        async editReserveDate(){
            if(!this.valid()) return;
                try{
                    this.loading = true;
                      const response = await this.$http.post(`/caja/rooms/set_reserve_date`,this.roomEdit);
            if(response.status == 200){
                this.$toast.success("Fecha de reserva actualizada");
                this.$emit("getTables");
                this.close();
            }
                }catch(e){
                    console.log("🚀 ~ file: edit_reserve.vue:138 ~ editReserveDate ~ e:", e)
                    this.$toast.error("Ocurrió un error");

                }finally{
                    this.loading = false;
                }

        },
        valid(){
            let pass = true;
            let {table_id,checkin_date,checkin_time,duration} = this.roomEdit;
            if(!table_id){
                this.$toast.error("Seleccione una habitación");
                pass = false;
            }
            if(!checkin_date){
                this.$toast.error("Seleccione una fecha");
                pass = false;
            }
            if(!checkin_time){
                this.$toast.error("Seleccione una hora");
                pass = false;
            }

            if(!duration){
                this.$toast.error("Ingrese una duración");
                pass = false;
            }
            return pass;

        },
          async checkDateReserve() {
            try {
                this.loading = true;
                let { id, table_id, checkin_date, checkin_time, duration } = this.roomEdit;
                const response = await this.$http.post(
                    "/caja/rooms/check_reserve",
                    {
                        id,
                        table_id,
                        checkin_date,
                        checkin_time,
                        duration
                    }
                );
                if (response.status == 200) {
                    const { success, message } = response.data;
                    if (success) {
                        this.$toast.success(message);
                    } else {
                        this.roomEdit.table_id = null;
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        setTable(){
            let {table_id} = this.roomEdit;
            let table = this.all_tables.find(f => f.id == table_id);
            let floor = this.all_floors.find(f => f.id == table.floor_id);
            let tower = this.towers.find(f => f.id == floor.tower_id);
            this.roomEdit.tower_id = tower.id;
            this.filterFloorsByTower(tower.id);
            this.roomEdit.floor_id = floor.id;
            this.filterTablesByFloor(floor.id);
            this.roomEdit.table_id = table.id;
                        
        },
async changeTable() {
            this.textLoading = "Verificando reserva...";
            await this.checkDateReserve();

        },
        async open(){
            console.log("🚀 ~ file: edit_reserve.vue:125 ~ open ~ this.roomEdit:", this.roomEdit)
            await this.getTables();
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http("/caja/rooms/tables");
                if (response.status == 200) {
                    const { tables, towers, floors } = response.data;
                    //  this.tables = tables.filter(f => f.number != "caja");
                    this.all_tables = tables;

                    this.all_floors = floors;
                    this.towers = towers;
                    this.setTable();
                    // let [tower] = towers;
                    // this.tower_id = tower.id;

                    // this.filterFloorsByTower(tower.id);
                    // let [floor] = floors;
                    // this.filterTablesByFloor(floor.id);
                } else {
                    this.$toast.warning("Ocurrió un error");
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);

                this.$toast.warning("Ocurrió un error");
            }
        },
        filterTablesByFloor(floor_id) {
            this.roomEdit.floor_id = floor_id;
            this.tables = this.all_tables.filter(f => {
                delete f.tower_name;
                return f.floor_id == floor_id;
            });
            this.roomEdit.table_id = null;
        },
        filterFloorsByTower(tower_id) {
            this.roomEdit.tower_id = tower_id;
            this.floors = this.all_floors.filter(f => {
                return f.tower_id == tower_id;
            });
            let [floor] = this.floors;
            if (floor) {
                this.filterTablesByFloor(floor.id);
            } else {
                this.roomEdit.floor_id = null;
                this.tables = [];
            }
        },

        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
