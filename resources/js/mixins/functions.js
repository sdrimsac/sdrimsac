import { isNumber } from "lodash";

export const setDefaultSeriesByMultipleDocumentTypes = {
    data() {
        return {};
    },
    methods: {
        generalDisabledSeries() {
            if (this.authUser === undefined) return false;

            return (
                this.configuration.restrict_series_selection_seller &&
                this.authUser.type !== "admin"
            );
        },
        generalSetDefaultSerieByDocumentType(document_type_id) {
            if (this.authUser !== undefined) {
                if (this.authUser.multiple_default_document_types) {
                    const default_document_type_serie = _.find(
                        this.authUser.default_document_types,
                        { document_type_id: document_type_id }
                    );

                    if (default_document_type_serie) {
                        const exist_serie = _.find(this.series, {
                            id: default_document_type_serie.series_id
                        });
                        if (exist_serie)
                            this.form.series_id =
                                default_document_type_serie.series_id;
                    }
                }
            }
        }
    }
};

export const functions = {
    data() {
        return {
            loading_search_exchange_rate: false,
            loading_search: false,
            percentage_igv: 0.18
        };
    },
    methods: {
        searchExchangeRate() {
            // return new Promise((resolve) => {
            //     this.loading_search_exchange_rate = true
            //     this.$http.post(`/services/exchange_rate`, this.form)
            //         .then(response => {
            //             let res = response.data
            //             if (res.success) {
            //                 this.data = res.data;
            //                 this.form.buy = res.data[this.form.cur_date].buy;
            //                 this.form.sell = res.data[this.form.cur_date].sell;
            //                 this.$message.success(res.message)
            //             } else {
            //                 this.$message.error(res.message)
            //                 this.loading_search_exchange_rate = false
            //             }
            //             resolve()
            //         })
            //         .catch(error => {
            //             console.log(error.response)
            //             this.loading_search_exchange_rate = false
            //         })
            //         .then(() => {
            //             this.loading_search_exchange_rate = false
            //         })
            // })
            return 1;
        },

        searchServiceNumber() {
            return new Promise(resolve => {
                this.loading_search = true;
                let identity_document_type_name = "";
                if (this.form.identity_document_type_id === "6") {
                    identity_document_type_name = "ruc";
                }
                if (this.form.identity_document_type_id === "1") {
                    identity_document_type_name = "dni";
                }
                this.$http
                    .get(
                        `/services/${identity_document_type_name}/${this.form.number}`
                    )
                    .then(response => {
                        console.log(response.data);
                        let res = response.data;
                        if (res.success) {
                            this.form.name = res.data.name;
                            this.form.trade_name = res.data.trade_name;
                            this.form.address = res.data.address;
                            this.form.department_id = res.data.department_id;
                            this.form.province_id = res.data.province_id;
                            this.form.district_id = res.data.district_id;
                            this.form.phone = res.data.phone;
                        } else {
                            this.$showSAlert({
                                title: "ERROR",
                                text: res.message,
                                type: "error"
                            });
                        }
                        resolve();
                    })
                    .catch(error => {
                        console.log(error.response);
                    })
                    .then(() => {
                        this.loading_search = false;
                    });
            });
        },

        async getPercentageIgv() {
            await this.$http
                .post(`/store/get_igv`, {
                    establishment_id: this.form.establishment_id,
                    date: this.form.date_of_issue
                })
                .then(response => {
                    let data = response.data;
                    if (data) {
                        data = data.toString();
                        data = data.replace(",", ".");
                        this.percentage_igv = Number(data);
                    }
                });
        },
        async getPercentageIgvWithParams(establishment_id, date_of_issue) {
            await this.$http
                .post(`/store/get_igv`, {
                    establishment_id: establishment_id,
                    date: date_of_issue
                })
                .then(response => {
                    let data = response.data;
                    data = data.toString();
                    data = data.replace(",", ".");
                    this.percentage_igv = Number(data);
                });
        }
    }
};

export const exchangeRate = {
    methods: {
        async searchExchangeRateByDate(exchange_rate_date) {
            let response = await this.$http.get(
                `/service/exchange?date=${exchange_rate_date}`
            );
            console.log(response);
            let data = response.data;
            if (isNumber(data)) {
                return data;
            }
            if (data.includes(",")) {
                data = data.replace(",", ".");
            }

            let num = Number(data);
            return isNaN(num) ? 1 : num;
        }
    }
};

export const serviceNumber = {
    data() {
        return {
            loading_search: false
        };
    },
    methods: {
        filterProvince() {
            this.form.province_id = null;
            this.form.district_id = null;
            this.filterProvinces();
        },
        filterProvinces() {
            this.provinces = this.all_provinces.filter(f => {
                return f.department_id === this.form.department_id;
            });
        },
        filterDistrict() {
            this.form.district_id = null;
            this.filterDistricts();
        },
        filterDistricts() {
            this.districts = this.all_districts.filter(f => {
                return f.province_id === this.form.province_id;
            });
        },
        async searchServiceNumberByType2() {
            if (this.form.number === "") {
                this.$showSAlert({
                    title: "ERROR",
                    text: "Ingresar el número a buscar",
                    type: "error"
                });
                return;
            }
            let identity_document_type_name = "";
            if (this.form.identity_document_type_id === "6") {
                identity_document_type_name = "ruc";
            }
            if (this.form.identity_document_type_id === "1") {
                identity_document_type_name = "dni";
            }
            this.loading_search = true;
            try {
                let response = await this.$http.get(
                    `/service/${identity_document_type_name}/${this.form.number}`
                );
                // console.log(response.data.data)
                if (response.data.success) {
                    let data = response.data.data;
                    
                    // Manejo específico para respuesta de Factiliza (DNI)
                    if (data.nombre_completo) {
                        this.form.name = data.nombre_completo;
                        
                        // Si hay dirección disponible
                        if (data.direccion) {
                            this.form.address = data.direccion;
                        } else if (data.direccion_completa) {
                            this.form.address = data.direccion_completa;
                        }
                        
                        // Manejo de ubigeo
                        if (data.ubigeo_sunat) {
                            this.setLocationByUbigeo(data.ubigeo_sunat);
                        } else if (data.ubigeo && Array.isArray(data.ubigeo) && data.ubigeo.length >= 3) {
                            this.setLocationByUbigeo(data.ubigeo[2]);
                        }
                    } else {
                        // Respuesta tradicional
                        this.form.name = data.nombre_completo || data.name;
                        this.form.trade_name = data.trade_name;
                        this.form.address = data.address;
                        this.form.department_id = data.department_id;
                        this.form.province_id = data.province_id;
                        this.form.district_id = data.district_id;
                        this.form.phone = data.phone;
                    }
                } else {
                    this.$showSAlert({
                        title: "ERROR",
                        text: response.data.notification,
                        type: "error"
                    });
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error");
            } finally {
                this.loading_search = false;
            }
        },
        async searchServiceNumberByType() {
            if (this.form.number === "") {
                /* this.$message.error("Ingresar el número a buscar"); */
                this.$showSAlert({
                    title: "ERROR",
                    text: "Ingresar el número a buscar",
                    type: "error"
                });
                return;
            }
            let identity_document_type_name = "";
            if (this.form.identity_document_type_id === "6") {
                identity_document_type_name = "ruc";
            }
            if (this.form.identity_document_type_id === "1") {
                identity_document_type_name = "dni";
            }
            if (this.form.identity_document_type_id === "4") {
                identity_document_type_name = "ce";
            }
            this.loading_search = true;
            let response = null;
            try{
                if (this.form.identity_document_type_id === "4") {
                    response = await this.$http.get(
                        `/search-ce/${this.form.number}`
                    );
                } else {
                    response = await this.$http.get(
                        `/service/${identity_document_type_name}/${this.form.number}`
                    );
                }
                console.log("🚀 ~ searchServiceNumberByType ~ response:", response)
                // console.log(response.data.data)
                if (response.data.success) {
                    let data = response.data.data;
                    if (this.form.identity_document_type_id === "4") {
                        let name = data.nombres;
                        let last_name =
                        data.apellido_paterno + " " + data.apellido_materno;
                     
                        this.form.name = last_name + ", " + name;
                    
                    } else if (this.form.identity_document_type_id === "1") {
                        // Manejo específico para DNI con respuesta de Factiliza
                        if (data.nombre_completo) {
                            // Respuesta de Factiliza
                            this.form.name = data.nombre_completo;
                            
                            // Si hay dirección disponible
                            if (data.direccion) {
                                this.form.address = data.direccion;
                            } else if (data.direccion_completa) {
                                this.form.address = data.direccion_completa;
                            }
                            
                            // Manejo de ubigeo - usar el de SUNAT si está disponible
                            if (data.ubigeo_sunat) {
                                // Buscar departamento, provincia y distrito por ubigeo SUNAT
                                this.setLocationByUbigeo(data.ubigeo_sunat);
                            } else if (data.ubigeo && Array.isArray(data.ubigeo) && data.ubigeo.length >= 3) {
                                // Si viene como array, usar el ubigeo completo
                                this.setLocationByUbigeo(data.ubigeo[2]);
                            }
                        } else {
                            // Respuesta tradicional
                            if(this.form.workers){
                                let firstName = data.nombres.split(" ")[0];
                                this.form.name = firstName + " " + data.apellido_paterno;
                            }else{
                                this.form.name = data.name;
                            }
                            this.form.trade_name = data.trade_name;
                            this.form.address = data.address;
                            if(!this.form.workers){
                                this.form.department_id = data.department_id;
                                this.form.province_id = data.province_id;
                                this.form.district_id = data.district_id;
                                this.form.phone = data.phone;
                                this.filterProvinces();
                                this.filterDistricts();
                            }
                        }
                    } else {
                        // Para RUC u otros tipos de documento
                        if(this.form.workers){
                            let firstName = data.nombres.split(" ")[0];
                            this.form.name = firstName + " " + data.apellido_paterno;
                        }else{
                            this.form.name = data.name;
                        }
                        this.form.trade_name = data.trade_name;
                        this.form.address = data.address;
                        if(!this.form.workers){
                            this.form.department_id = data.department_id;
                            this.form.province_id = data.province_id;
                            this.form.district_id = data.district_id;
                            this.form.phone = data.phone;
                            this.filterProvinces();
                            this.filterDistricts();
                        }
                    }
    
                
                } else {
                    this.$showSAlert({
                        title: "ERROR",
                        text: response.data.notification,
                        type: "error"
                    });
                }
            }catch(e){
                console.log(e)
                this.$showSAlert({
                    title: "ERROR",
                    text: "Ocurrió un error",
                    type: "error"
                });
            }
            this.loading_search = false;
        },
        setLocationByUbigeo(ubigeo) {
            // Método para establecer departamento, provincia y distrito basado en ubigeo
            if (!ubigeo) return;
            
            // El ubigeo tiene formato: DDPPDD (6 dígitos)
            // DD = Departamento, PP = Provincia, DD = Distrito
            const ubigeoStr = ubigeo.toString().padStart(6, '0');
            const departmentCode = ubigeoStr.substring(0, 2);
            const provinceCode = ubigeoStr.substring(0, 4);
            const districtCode = ubigeoStr;
            
            // Buscar y establecer departamento
            if (this.all_departments) {
                const department = this.all_departments.find(d => d.code === departmentCode);
                if (department) {
                    this.form.department_id = department.id;
                    this.filterProvinces();
                    
                    // Buscar y establecer provincia
                    if (this.provinces) {
                        const province = this.provinces.find(p => p.code === provinceCode);
                        if (province) {
                            this.form.province_id = province.id;
                            this.filterDistricts();
                            
                            // Buscar y establecer distrito
                            if (this.districts) {
                                const district = this.districts.find(d => d.code === districtCode);
                                if (district) {
                                    this.form.district_id = district.id;
                                }
                            }
                        }
                    }
                }
            }
        },
        async searchServiceNumber() {
            if (this.form.number === "") {
                this.$showSAlert({
                    title: "ERROR",
                    text: "Ingresar el número a buscar",
                    type: "error"
                });
                return;
            }
            this.loading_search = true;
            let response = await this.$http.get(
                `/services/ruc/${this.form.number}`
            );
            if (response.data.success) {
                let data = response.data.data;
                this.form.name = data.name;
                this.form.trade_name = data.trade_name;
            } else {
                this.$showSAlert({
                    title: "ERROR",
                    text: response.data.message,
                    type: "error"
                });
            }
            this.loading_search = false;
        }
    }
};
