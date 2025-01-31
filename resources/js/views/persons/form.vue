<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        width="80%"
        @close="close"
        @open="create"
        append-to-body
        @opened="opened"
        :close-on-click-modal="false"
        class="rounded-dialog"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.identity_document_type_id
                            }"
                        >
                            <label class="control-label">
                                <i class="fas fas fa-id-card"></i> Doc.
                                Identidad
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Este campo es obligatorio...!!!"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-info-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-select
                                v-model="form.identity_document_type_id"
                                filterable
                                popper-class="el-select-identity_document_type"
                                dusk="identity_document_type_id"
                                @change="changeIdentityDocType"
                            >
                                <el-option
                                    v-for="option in identity_document_types"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.identity_document_type_id"
                                v-text="errors.identity_document_type_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <label class="control-label">
                                <i class="fas fa-id-card"></i>
                                <i class="fas fa-hashtag"></i>
                                Número de Doc.
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Este campo es obligatorio...!!!"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-info-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <div
                                v-if="
                                    api_service_token != false &&
                                        form.identity_document_type_id !== '4'
                                "
                            >
                                <x-input-service
                                    :identity_document_type_id="
                                        form.identity_document_type_id
                                    "
                                    v-model="form.number"
                                    @search="searchNumber"
                                ></x-input-service>
                            </div>
                            <div v-else>
                                <el-input
                                    ref="number"
                                    v-model="form.number"
                                    :maxlength="maxLength"
                                    dusk="number"
                                    @input="validateNumericInput('number')"
                                >
                                    <template
                                        v-if="
                                            form.identity_document_type_id ===
                                                '6' ||
                                                form.identity_document_type_id ===
                                                    '1' ||
                                                form.identity_document_type_id ===
                                                    '4'
                                        "
                                    >
                                        <el-button
                                            slot="append"
                                            :loading="loading_search"
                                            icon="el-icon-search"
                                            @click.prevent="searchCustomer"
                                        ></el-button>
                                    </template>
                                    <i
                                        slot="prefix"
                                        class="el-icon-edit-outline"
                                    ></i>
                                </el-input>
                            </div>

                            <small
                                class="text-danger"
                                v-if="errors.number"
                                v-text="errors.number[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-xl-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label class="control-label">
                                <i class="fas fa-tag"></i> Nombre
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Este campo es obligatorio...!!!"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-info-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model="form.name"
                                dusk="name"
                                @input="toUpperCase('name')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.name"
                                v-text="errors.name[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        class="col-12 col-lg-12 col-xl-12"
                        v-if="configuration.alias_client"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.alias }"
                        >
                            <label class="control-label">
                                <i class="fas fa-tag"></i>
                                Alias
                            </label>
                            <el-input
                                v-model="form.alias"
                                dusk="alias"
                                @input="toUpperCase('alias')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.alias"
                                v-text="errors.alias[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div
                        class="col-md-4"
                        v-if="form.identity_document_type_id !== '6'"
                    >
                        <label class="control-label">
                            <i class="fas fa-mars"></i>
                            <i class="fas fa-venus"></i>
                            Masculino
                        </label>
                        <el-select v-model="form.sex">
                            <el-option label="Másculino" value="M"></el-option>
                            <el-option label="Femenino" value="F"></el-option>
                        </el-select>
                    </div>
                    <div v-else class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.trade_name }"
                        >
                            <label class="control-label">
                                <i class="fas fa-building"></i> Nombre Comercial
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Este campo es obligatorio...!!!"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-info-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model="form.trade_name"
                                dusk="trade_name"
                                @input="toUpperCase('trade_name')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.trade_name"
                                v-text="errors.trade_name[0]"
                            ></small>
                        </div>
                    </div>
                </div>

                <!-- <div class="row" v-if="type === 'customers'">
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.person_type_id}">
                            <label class="control-label">Tipo de cliente</label>
                            <el-select v-model="form.person_type_id" filterable  >
                                <el-option v-for="option in person_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="text-danger" v-if="errors.person_type_id" v-text="errors.person_type_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group"  >
                            <label class="control-label">Comentario</label>
                            <el-input v-model="form.comment"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        </div>
                    </div>
        </div>-->

                <div class="row">
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.country_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-globe"></i> País
                            </label>
                            <el-select
                                v-model="form.country_id"
                                filterable
                                dusk="country_id"
                            >
                                <el-option
                                    v-for="option in countries"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.country_id"
                                v-text="errors.country_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.department_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-building"></i> Departamento
                            </label>
                            <el-select
                                v-model="form.department_id"
                                filterable
                                @change="filterProvince"
                                popper-class="el-select-departments"
                                dusk="department_id"
                            >
                                <el-option
                                    v-for="option in all_departments"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.department_id"
                                v-text="errors.department_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.province_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-city"></i> Provincia
                            </label>
                            <el-select
                                v-model="form.province_id"
                                filterable
                                @change="filterDistrict"
                                popper-class="el-select-provinces"
                                dusk="province_id"
                            >
                                <el-option
                                    v-for="option in provinces"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.province_id"
                                v-text="errors.province_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.district_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-map-marker-alt"></i> Distrito
                            </label>
                            <el-select
                                v-model="form.district_id"
                                filterable
                                popper-class="el-select-districts"
                                dusk="district_id"
                            >
                                <el-option
                                    v-for="option in districts"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.district_id"
                                v-text="errors.district_id[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.address }"
                        >
                            <label class="control-label">
                                <i class="fas fa-map-marker-alt"></i>
                                <i class="fas fa-globe"></i>
                                Dirección
                            </label>
                            <el-input
                                v-model="form.address"
                                dusk="address"
                                @input="toUpperCase('address')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.address"
                                v-text="errors.address[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.adderss_secondary }"
                        >
                            <label class="control-label">
                                <i class="fas fa-map-marker-alt"></i>
                                <i class="fas fa-globe"></i>
                                Dirección Real del cliente
                            </label>
                            <el-input
                                v-model="form.adderss_secondary"
                                dusk="adderss_secondary"
                                @input="toUpperCase('adderss_secondary')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.adderss_secondary"
                                v-text="errors.adderss_secondary[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-6">
                        <!-- create a select with options of zones -->
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.client_zone_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-map-marked-alt"></i> Zona
                            </label>
                            <el-select
                                v-model="form.client_zone_id"
                                filterable
                                dusk="client_zone_id"
                            >
                                <el-option
                                    v-for="option in zones"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.client_zone_id"
                                v-text="errors.client_zone_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.telephone }"
                        >
                            <label class="control-label">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </label>
                            <el-input
                                v-model="form.telephone"
                                dusk="telephone"
                                @input="toUpperCase('telephone')"
                                maxlength="9"
                                show-word-limit
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.telephone"
                                v-text="errors.telephone[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-xl-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.email }"
                        >
                            <label class="control-label">
                                <i class="fas fa-envelope"></i> Correo
                                electrónico
                            </label>
                            <el-input
                                v-model="form.email"
                                dusk="email"
                                @input="toUpperCase('email')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.email"
                                v-text="errors.email[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="configuration.mod_renta">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.occupation }"
                        >
                            <label class="control-label"
                                >Ocupacion Cliente</label
                            >
                            <el-input
                                type="text"
                                v-model="form.occupation"
                                @input="toUpperCase('occupation')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.occupation"
                                v-text="errors.occupation[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="configuration.mod_renta">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.ref_origin }"
                        >
                            <label class="control-label"
                                >Referencia de Procedencia</label
                            >
                            <el-input
                                type="text"
                                v-model="form.ref_origin"
                                @input="toUpperCase('ref_origin')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.ref_origin"
                                v-text="errors.ref_origin[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="configuration.mod_renta">
                        <div class="form-group">
                            <label class="control-label"
                                >Tipo De Parentesco</label
                            >
                            <el-select v-model="form.parient_id" filterable>
                                <el-option
                                    v-for="option in parent"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="configuration.mod_renta">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name_family }"
                        >
                            <label class="control-label"
                                >Nombre Familiar Emergencia</label
                            >
                            <el-input
                                type="text"
                                v-model="form.name_family"
                                @input="toUpperCase('telephone_family')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.name_family"
                                v-text="errors.name_family[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="configuration.mod_renta">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.telephone_family }"
                        >
                            <label class="control-label"
                                >Telefono Familiar Emergencia</label
                            >
                            <el-input
                                type="text"
                                v-model="form.telephone_family"
                                @input="toUpperCase('telephone_family')"
                                maxlength="9"
                                show-word-limit
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.telephone_family"
                                v-text="errors.telephone_family[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="configuration.mod_renta">
                        <div class="form-group">
                            <label class="control-label">
                                Imagen De Cliente
                                <span class="text-danger"></span>
                            </label>
                            <el-upload
                                class="avatar-uploader text-center bg-white"
                                :data="{ type: 'workers' }"
                                :headers="headers"
                                :action="`/${resource}/uploads`"
                                :show-file-list="false"
                                :on-success="onSuccess"
                            >
                                <img
                                    v-if="form.image_url"
                                    :src="form.image_url"
                                    class="avatar"
                                />
                                <i
                                    v-else
                                    class="el-icon-plus avatar-uploader-icon"
                                ></i>
                            </el-upload>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" v-if="form.state">
                        <div class="form-group">
                            <label class="control-label"
                                >Estado del Contribuyente</label
                            >
                            <template v-if="form.state == 'ACTIVO'">
                                <el-alert
                                    :title="`${form.state}`"
                                    type="success"
                                    show-icon
                                    :closable="false"
                                ></el-alert>
                            </template>
                            <template v-else>
                                <el-alert
                                    :title="`${form.state}`"
                                    type="error"
                                    show-icon
                                    :closable="false"
                                ></el-alert>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="form.condition">
                        <div class="form-group">
                            <label class="control-label"
                                >Condición del Contribuyente</label
                            >
                            <template v-if="form.condition == 'HABIDO'">
                                <el-alert
                                    :title="`${form.condition}`"
                                    type="success"
                                    show-icon
                                    :closable="false"
                                ></el-alert>
                            </template>
                            <template v-else>
                                <el-alert
                                    :title="`${form.condition}`"
                                    type="error"
                                    show-icon
                                    :closable="false"
                                ></el-alert>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" v-if="type === 'suppliers'">
                    <div class="col-md-6 center-el-checkbox">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.perception_agent }"
                        >
                            <el-checkbox v-model="form.perception_agent"
                                >¿Es agente de percepción?</el-checkbox
                            >
                            <br />
                            <small
                                class="text-danger"
                                v-if="errors.perception_agent"
                                v-text="errors.perception_agent[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        class="col-md-6"
                        v-if="type === 'suppliers'"
                        v-show="form.perception_agent"
                    >
                        <div class="form-group">
                            <label class="control-label"
                                >Porcentaje de percepción</label
                            >

                            <el-input v-model="form.percentage_perception">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                        </div>
                    </div>
                </div>

                <div
                    class="row m-t-10"
                    v-for="(row, index) in form.addresses"
                    :key="index"
                >
                    <div class="col-md-12">
                        <label class="control-label" v-if="index === 0"
                            >Dirección principal</label
                        >
                        <label class="control-label" v-else>
                            Dirección secundaria # {{ index }}
                            <el-button
                                size="mini"
                                icon="el-icon-minus"
                                @click.prevent="clickRemoveAddress(index)"
                                class="btn-default-danger"
                                >Eliminar dirección</el-button
                            >
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.country_id }"
                        >
                            <label class="control-label">País</label>
                            <el-select v-model="row.country_id" filterable>
                                <el-option
                                    v-for="option in countries"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.country_id"
                                v-text="errors.country_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.location_id }"
                        >
                            <label class="control-label">Ubigeo</label>
                            <el-cascader
                                :options="locations"
                                v-model="row.location_id"
                                :clearable="true"
                                filterable
                            ></el-cascader>
                            <small
                                class="text-danger"
                                v-if="errors.location_id"
                                v-text="errors.location_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.address }"
                        >
                            <label class="control-label">Dirección</label>
                            <el-input
                                v-model="row.address"
                                @input="toUpperCase('row.address')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.address"
                                v-text="errors.address[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.phone }"
                        >
                            <label class="control-label">Teléfono</label>
                            <el-input
                                v-model="row.phone"
                                @input="validateNumericInput('row.phone')"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.phone"
                                v-text="errors.phone[0]"
                            ></small>
                        </div>
                    </div>
                </div>

                <template
                    v-if="
                        type == 'customers' &&
                            configuration.credit_list &&
                            (typeUser == 'admin' ||
                                typeUser == 'superadmin' ||
                                isArca)
                    "
                >
                    <div class="row">
                        <div class="col-3">
                            <label for="has_credit_line" class="w-100"
                                >Tiene linea de crédito</label
                            >
                            <el-checkbox
                                v-model="form.has_credit_line"
                                :checked="form.has_credit_line"
                            ></el-checkbox>
                        </div>
                        <div class="col-3">
                            <label for="credit_line"
                                >Monto - linea de crédito</label
                            >
                            <el-input
                                v-model="form.credit_line"
                                :disabled="!form.has_credit_line"
                                type="number"
                                min="0"
                                step="0.01"
                            ></el-input>
                        </div>
                    </div>
                </template>
                <div class="row" v-if="configuration.consolidated_quotations">
                    <div class="col-8 col-lg-8 col-xl-8">
                        <label for="document_type">
                            <i class="fas fa-file-invoice"></i> Tipo de
                            documento
                        </label>

                        <el-select
                            v-model="form.document_type_id"
                            filterable
                            popper-class="el-select-document_type"
                            dusk="document_type"
                        >
                            <el-option
                                v-for="(option, idx) in document_types"
                                :key="idx"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-4 col-lg-4 col-xl-4">
                        <label for="varios"
                            >Clientes varios
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="La boleta o nota se emitirá a nombre de clientes varios."
                                placement="top"
                            >
                                <i class="fas fa-info-circle text-danger"></i>
                            </el-tooltip>
                        </label>
                        <el-checkbox
                            @change="changeVarios"
                            v-model="form.varios"
                            :checked="form.varios"
                        ></el-checkbox>
                    </div>
                </div>
                <div class="row" v-if="configuration.consolidated_quotations && !configuration.consolidated_quotation_details">
                    <div class="col-8 col-lg-8 col-xl-8">
                        <div class="form-group">
                            <label class="control-label"
                                >Politica de precio</label
                            >
                            <el-select
                                v-model="item_unit_type"
                                filterable
                                clearable
                                popper-class="el-select-identity_document_type"
                                dusk="item_unit_type"
                            >
                                <el-option
                                    v-for="(option, idx) in item_unit_types"
                                    :key="idx"
                                    :value="option"
                                    :label="option"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-4 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <br />
                            <el-button
                                type="primary"
                                @click="clickAddItemUnitType"
                                icon="el-icon-plus"
                                >Agregar</el-button
                            >
                        </div>
                    </div>
                </div>
                <div
                    class="row"
                    v-if="
                        form.item_unit_types && form.item_unit_types.length > 0
                    "
                >
                    <el-button-group>
                        <el-button
                            type="primary"
                            icon="el-icon-delete"
                            v-for="(item, index) in form.item_unit_types"
                            :key="index"
                            @click="removeItemUnitType(index)"
                            >{{ item }}</el-button
                        >
                    </el-button-group>
                </div>
            </div>
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <!-- Botón Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close()"
                >
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
                <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                >
                    <span>Guardar</span>
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
import { serviceNumber } from "../../mixins/functions";
/* import Swal from 'sweetalert2'; */

export default {
    mixins: [serviceNumber],
    props: [
        "worker",
        "showDialog",
        "type",
        "recordId",
        "external",
        "document_type_id",
        "input_person",
        "user_id",
        "newTech",
        "typeUser",
        "isArca",
        "fromPos"
    ],
    data() {
        return {
            headers: headers_token,
            image_url: null,
            item_unit_type: null,
            // item_unit_types: [],
            item_unit_types_general: [],
            zones: [],
            social_medias: [],
            loading_submit: false,
            titleDialog: null,
            resource: this.worker ? "caja/worker/persons" : "persons",
            errors: {},
            api_service_token: false,
            form: {
                item_unit_types: []
            },
            countries: [],
            all_departments: [],
            all_provinces: [],
            all_districts: [],
            provinces: [],
            districts: [],
            locations: [],
            person_types: [],
            identity_document_types: [],
            all_users: [],
            configuration: {},
            item_unit_types: [],
            document_types: [
                {
                    id: "01",
                    description: "FACTURA ELECTRÓNICA"
                },
                {
                    id: "03",
                    description: "BOLETA DE VENTA ELECTRÓNICA"
                },
                {
                    id: "80",
                    description: "NOTA DE VENTA ELECTRÓNICA"
                }
            ]
        };
    },

    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.api_service_token = response.data.api_service_token;
            this.social_medias = response.data.social_media;
            this.all_users = response.data.users;
            this.countries = response.data.countries;
            this.all_departments = response.data.departments;
            this.all_provinces = response.data.provinces;
            this.zones = response.data.zones;
            this.all_districts = response.data.districts;
            this.identity_document_types =
                response.data.identity_document_types;
            this.locations = response.data.locations;
            this.person_types = response.data.person_types;
            this.configuration = response.data.configuration;
            this.item_unit_types_general = response.data.item_unit_types;
            this.item_unit_types = this.item_unit_types_general;
            this.parent = response.data.parent;
            console.log(
                "🚀 ~ file: form.vue ~ line 153 ~ created ~ parent",
                this.parent
            );
        });
        if (this.fromPos) {
            this.create();
        }
    },
    computed: {
        maxLength: function() {
            if (this.form.identity_document_type_id === "6") {
                return 11;
            }
            if (this.form.identity_document_type_id === "1") {
                return 8;
            }
            if (this.form.identity_document_type_id === "-") {
                return 8;
            }
        }
    },
    methods: {
        onSuccess(response, file, fileList) {
            if (response.success) {
                this.form.image = response.data.filename;
                this.form.image_url = response.data.temp_image;
                this.form.temp_path = response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }
        },
        changeVarios() {
            let { document_type_id } = this.form;
            if (!document_type_id || document_type_id == "01") {
                this.form.document_type_id = "80";
            }
        },
        removeItemUnitType(idx) {
            this.form.item_unit_types.splice(idx, 1);
            this.item_unit_types = this.item_unit_types_general.filter(
                item => !this.form.item_unit_types.includes(item)
            );
        },
        clickAddItemUnitType() {
            if (this.item_unit_type) {
                this.form.item_unit_types.push(this.item_unit_type);
                this.item_unit_types = this.item_unit_types_general.filter(
                    item => !this.form.item_unit_types.includes(item)
                );
                this.item_unit_type = null;
            }
        },
        nuevoMetodo() {
            let admin = this.all_users.find(user => user.type == "admin");
            if (admin) {
                this.form.seller_id = admin.id;
            } else {
                if (this.all_users.length != 0) {
                    this.form.seller_id = this.all_users[0].id;
                }
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                varios: false,
                has_credit_line: false,
                credit_line: 0.0,
                id: null,
                type: this.type,
                identity_document_type_id: "6",
                number: "",
                name: null,
                alias: null,
                adderss_secondary: null,
                trade_name: null,
                country_id: "PE",
                department_id: null,
                province_id: null,
                district_id: null,
                address: null,
                telephone: null,
                condition: null,
                state: null,
                email: null,
                perception_agent: false,
                percentage_perception: 0,
                person_type_id: null,
                comment: null,
                addresses: [],
                seller_id: null,
                item_unit_types: [],
                ref_origin: null,
                name_family: null,
                telephone_family: null,
                occupation: null,
                parient_id: null,
            };
        },
        async opened() {
            // this.form.seller_id = this.user_id;
            if (this.external && this.input_person) {
                if (
                    this.form.number.length === 8 ||
                    this.form.number.length === 11
                ) {
                    if (this.api_service_token != false) {
                        await this.$eventHub.$emit("enableClickSearch");
                    } else {
                        this.searchCustomer();
                    }
                }
            }
        },

        create() {
            console.log(
                "🚀 ~ file: form.vue:809 ~ create ~ this.user_id:",
                this.user_id
            );
            this.initForm();
            if (this.external) {
                if (this.document_type_id === "01") {
                    this.form.identity_document_type_id = "6";
                }
                if (this.document_type_id === "03") {
                    this.form.identity_document_type_id = "1";
                }

                console.log(
                    "🚀 ~ create ~ this.input_person:",
                    this.input_person
                );
                if (this.input_person) {
                    this.form.identity_document_type_id = this.input_person
                        .identity_document_type_id
                        ? this.input_person.identity_document_type_id
                        : this.form.identity_document_type_id;
                    this.form.number = this.input_person.number
                        ? this.input_person.number
                        : "";
                    if (
                        this.input_person.number &&
                        this.input_person.number != ""
                    ) {
                        if (this.form.number.length == 11) {
                            this.form.identity_document_type_id = "6";
                        } else {
                            this.form.identity_document_type_id = "1";
                        }
                    }
                }
            }

            if (this.type == undefined) {
                this.titleDialog = this.newTech
                    ? "Nuevo Técnico"
                    : "Nuevo Cliente";
            }
            if (this.type === "customers") {
                this.titleDialog = this.recordId
                    ? "Editar Cliente"
                    : "Nuevo Cliente";
            }
            if (this.type === "suppliers") {
                this.titleDialog = this.recordId
                    ? "Editar Proveedor"
                    : "Nuevo Proveedor";
            }

            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;

                        this.filterProvinces();
                        this.filterDistricts();
                    });
            }
        },
        clickAddAddress() {
            /* this.form.more_address.push({
                    location_id: [],
                    address: null,
                })*/

            this.form.addresses.push({
                id: null,
                country_id: "PE",
                location_id: [],
                address: null,
                email: null,
                phone: null,
                main: false
            });
        },
        submit() {
            // Convert all text inputs to uppercase before submission
            Object.keys(this.form).forEach(field => {
                if (typeof this.form[field] === "string") {
                    this.form[field] = this.form[field].toUpperCase();
                }
            });
            this.nuevoMetodo();
            if (!this.form.seller_id) {
                this.$showSAlert(
                    "ALERTA",
                    "Debe seleccionar un asesor",
                    "error"
                );
                return;
            }
            if (
                this.form.identity_document_type_id == "6" &&
                this.form.number.length != 11
            ) {
                this.$showSAlert(
                    "ALERTA",
                    "La longitud del RUC debe ser de 11",
                    "error"
                );
                return;
            }
            if (
                this.form.identity_document_type_id == "1" &&
                this.form.number.length != 8
            ) {
                this.$showSAlert(
                    "ALERTA",
                    "La longitud del DNI debe ser de 8",
                    "error"
                );
                return;
            }
            if (!this.form.alias || this.form.alias.trim() === "") {
                delete this.form.alias;
            }
            this.loading_submit = true;
            console.log(
                "🚀 ~ file: form.vue:893 ~ submit ~ this.form:",
                this.form
            );
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$showSAlert("Éxito", response.data.message);
                        this.$emit("add_customer", response.data.id);
                        if (this.external) {
                            this.$eventHub.$emit(
                                "reloadDataPersons",
                                response.data.id
                            );
                            this.$emit("reloadDataPersons", response.data.id);
                        } else {
                            this.$eventHub.$emit("reloadData");
                        }
                        this.close();
                    } else {
                        this.$showSAlert(
                            "ALERTA",
                            response.data.message,
                            "error"
                        );
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error.response.data.errors);
                        this.errors = error.response.data.errors;
                        this.$showSAlert(
                            "ALERTA",
                            "Por favor, revise los campos e intente nuevamente.",
                            "error"
                        );
                    } else {
                        console.log(error);
                        this.$showSAlert(
                            "ALERTA",
                            "Ocurrió un error inesperado. Por favor, intente nuevamente.",
                            "error"
                        );
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        async changeIdentityDocType() {
            if (this.form.identity_document_type_id === "-") {
                await this.generateNumber();
            } else {
                this.recordId == null ? this.setDataDefaultCustomer() : null;
            }
        },
        setDataDefaultCustomer() {
            if (this.form.identity_document_type_id == "0") {
                this.form.number = "99999999";
                this.form.name = "Clientes - Varios";
            } else {
                this.form.number = "";
                this.form.name = null;
            }
        },
        close() {
            this.$eventHub.$emit("initInputPerson");
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        searchCustomer() {
            this.searchServiceNumberByType();
        },

        searchNumber(data) {
            if (data.ubigeo) {
                this.form.district_id = data.ubigeo[2];
                this.filterDistricts();
            }
            this.form.name =
                this.form.identity_document_type_id === "1"
                    ? data.nombre_completo
                    : data.nombre_o_razon_social;
            this.form.trade_name =
                this.form.identity_document_type_id === "6"
                    ? data.nombre_o_razon_social
                    : "";
            if (data.ubigeo) {
                this.form.location_id = data.ubigeo;
                this.form.department_id = data.ubigeo ? data.ubigeo[0] : null;
                this.form.province_id = data.ubigeo ? data.ubigeo[1] : null;
                this.form.district_id = data.ubigeo ? data.ubigeo[2] : null;
                this.filterProvinces();
                this.filterDistricts();
                this.form.address = data.direccion;
                this.form.condition = data.condicion;
                this.form.state = data.estado;
            }
        },
        clickRemoveAddress(index) {
            this.form.addresses.splice(index, 1);
        },
        /* async generateNumber() {
      this.loading = true;
      const response = await this.$http(`/persons/generate_number`);
      this.form.number = response.data.number;
      this.loading = false;
    }, */
        async generateNumber() {
            this.loading = true;
            try {
                const response = await this.$http.get(
                    `/customers/generate_number`
                );
                console.log("Número generado:", response.data.number); // Agrega esta línea para verificar el valor
                this.form.number = response.data.number;
            } catch (error) {
                console.error("Error generating number:", error);
                this.$toast.error(
                    "Error al generar el número. Por favor, inténtalo de nuevo."
                );
            } finally {
                this.loading = false;
            }
        },
        validateNumericInput(field) {
            const value = this.form[field];
            if (isNaN(value)) {
                this.$showSAlert("ALERTA", "Solo se aceptan Números", "error");
                this.form[field] = value.replace(/\D/g, "");
            }
        },
        toUpperCase(field) {
            if (field === "telephone") {
                this.form.telephone = this.form.telephone
                    .replace(/[^0-9]/g, "")
                    .slice(0, 9);
            }
            if (field === "name") {
                // Permitir letras (incluyendo Ñ/ñ), números, guiones, puntos y espacios
                this.form.name = this.form.name
                    .replace(/[^a-zA-ZñÑ0-9-\. ]/g, "")
                    .slice(0, 150);

                // Contar caracteres especiales (- y .)
                const specialCharCount = (this.form.name.match(/[-\.]/g) || [])
                    .length;

                // Si hay más de 2 caracteres especiales, eliminarlos
                if (specialCharCount > 4) {
                    this.form.name = this.form.name.replace(/[-\.]/g, "");
                }

                // Convertir a mayúsculas
                this.form.name = this.form.name?.toUpperCase();
            }
            if (field === "number") {
                this.form.number = this.form.number.replace(/[^0-9]/g, "");
                if (this.form.number.length > 20) {
                    this.form.number = this.form.number.slice(0, 20);
                }
            } else {
                this.form[field] = this.form[field]?.toUpperCase();
            }
        }
    }
};
</script>
