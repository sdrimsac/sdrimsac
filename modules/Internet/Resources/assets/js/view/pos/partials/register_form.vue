<template>
    <div v-loading="ordenLoading">
        <div>
            <div class="d-flex flex-wrap justify-content-between mb-2">
                <div v-for="(option, idx) in optionsMenu" :key="idx" v-show="option.visible">
                    <div v-if="option.visible" @click="trigerFunction(option.id)" class="btn_menusmall">
                        <i :class="option.icon"> </i>
                        <div class="text-center" style="margin-bottom: 2px">
                            <p style="margin: 0 !important; padding: 0 !important" v-for="(title, idx2) in option.title"
                                :key="idx2">
                                <span class="buttons_text_">{{ title }}</span>
                            </p>
                        </div>
                        <div>

                            <label v-if="option.id == 4" style="margin-left: 2px">{{ ordenInBox.length }}</label>
                            <label v-if="option.id == 5" style="margin-left: 2px">{{ ordensPending }}</label>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="bg-primary align-items-center rounded-top" style="padding-top: 8px"></div>
                <div :class="`p-1 bg-primary`">
                    <div class="d-flex justify-content-between col-md-12 mx-1 text-white">
                        <span style="font-size: 1.3rem;">
                            <i class="fas fa-tools mr-1"></i>
                            Registro de Instalación
                            <i class="fas fa-signal mr-1"></i>
                        </span>

                        <span @click="showRegister = !showRegister" v-if="screenWidth < 768" role="button" class="mx-5">
                            <i v-if="!showRegister" class="fas fa-eye"></i>
                            <i v-else class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div v-show="showRegister" class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header text-white" style="background-color: #1e5a85; padding: 8px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-0 text-white">Datos del Cliente</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-end">
                                                <el-checkbox v-model="oldClient" @change="setStartDate">
                                                    <h5 class="text-white">Migrar cliente</h5>
                                                </el-checkbox>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="document type">
                                                <i class="fas fa-id-card mr-1"></i>
                                                Tipo de Documento
                                            </label>
                                            <el-select v-model="form.identity_document_type_id">
                                                <el-option
                                                    v-for="(data, idx) in identityDocuments.filter(d => d.description !== 'Ced. Diplomática de identidad' && d.description !== 'SIN DOCUMENTO')"
                                                    :key="idx" :label="data.description" :value="data.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-md-5 mb-2">
                                            <label for="number" class="control-label">
                                                <i class="fas fa-address-card mr-1"></i>
                                                DNI/RUC/CE
                                                <a @click="openCreatePersonForm" href="#"
                                                    class="control-label font-weight-bold text-info">
                                                    [ + Nuevo]
                                                </a>
                                            </label>
                                            <el-input :disabled="!form.identity_document_type_id" class="to_left"
                                                style="width:100%;" v-model="form.number"
                                                :maxlength="form.identity_document_type_id == 6 ? 11 : (form.identity_document_type_id == 1 ? 8 : 12)"
                                                show-word-limit :controls="false">
                                                <el-button v-if="
                                                    form.identity_document_type_id == 1 ||
                                                    form.identity_document_type_id == 6 ||
                                                    form.identity_document_type_id == 'F' ||
                                                    form.identity_document_type_id == 'A'
                                                " slot="append" :loading="loading_search" icon="el-icon-search"
                                                    @click.prevent="searchPerson" class="btn_guardarsmall"></el-button>
                                            </el-input>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="zone_id">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                Zona
                                            </label>
                                            <!-- <el-select clearable filterable v-model="form.zone_id">
                                                <el-option v-for="(data, idx) in zones" :key="idx"
                                                    :label="data.description" :value="data.id">
                                                </el-option>
                                            </el-select> -->
                                            
                                                <el-select v-model="form.zone_id" filterable clearable
                                                    placeholder="Seleccione una zona">
                                                    <el-option v-for="zone in zones" :key="zone.id" :label="zone.description"
                                                        :value="zone.id"></el-option>
                                                </el-select>
                                            
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <!-- <label for="x">
                                                <i class="fas fa-user mr-1"></i>
                                                Cliente
                                            </label> -->
                                            <el-input v-model="form.name" :disabled="oldClient"
                                                :placeholder="'CLiente Contratante'"></el-input>
                                        </div>
                                        <div class="col-md-6 mb-2">

                                            <el-input v-model="phone" :placeholder="'Ingrese nro de WhatsApp'">

                                            </el-input>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6 mb-3">
                                                <span class="h5">
                                                    Costo de Instalación S/.
                                                    {{
                                                        this.form.install
                                                            ? this.form.install.toFixed(2)
                                                            : 0.0
                                                    }}
                                                </span>
                                                <br>
                                                <span class="h5" :class="installMonthly ? '' : 'text-danger'">
                                                    Mensualidad S/.
                                                    {{
                                                        this.form.total
                                                            ? this.form.total.toFixed(2)
                                                            : 0.0
                                                    }}
                                                    {{ days != 0 ? " x " + days + " días" : "" }}
                                                </span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="d-flex justify-content-end">
                                                    <span class="h4">
                                                        Total a Pagar S/.
                                                        <template v-if="installMonthly">
                                                            {{
                                                                (
                                                                    Number(
                                                                        this.form.install
                                                                            ? this.form.install
                                                                            : 0.0
                                                                    ) +
                                                                    Number(
                                                                        this.form.total
                                                                            ? this.form.total
                                                                            : 0.0
                                                                    )
                                                                ).toFixed(2)
                                                            }}
                                                        </template>
                                                        <template v-else>
                                                            {{
                                                                Number(
                                                                    this.form.install
                                                                        ? this.form.install
                                                                        : 0.0
                                                                ).toFixed(2)
                                                            }}
                                                        </template>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <el-checkbox v-if="!oldClient" v-model="installMonthly"
                                                            class="mr-auto" :disabled="!isVariationSelected">Cobrar
                                                            mensualidad</el-checkbox>
                                                    </div>
                                                    <div
                                                        class="col-md-6 d-flex justify-content-end align-items-end mb-2">
                                                        <!-- <el-button class="btn_cancelarsmall" @click="close">Cancelar</el-button> -->
                                                        <el-button class="btn_guardarsmall" type="primary"
                                                            @click="sendRegister" :disabled="!isVariationSelected">
                                                            <i class="fas fa-save mr-1"></i> Registrar Instalación
                                                        </el-button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <i class="fas fa-user-cog mr-1"></i>
                                Personal de Instalación
                            </h5>
                            <div class="col-md-12">
                                <label for="document type">Técnico</label>
                                <a @click="openCreateTechForm" href="#"
                                    class="control-label font-weight-bold text-info">
                                    [ + Nuevo]</a>
                                <el-select filterable clearable v-model="form.tech_id">
                                    <el-option v-for="(data, idx) in techs" :key="idx" v-if="data.active !== 0"
                                        :label="data.person.name" :value="data.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                    </div>
                    <br /> -->
                    <div class="row" v-if="form.name">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header text-white" style="background-color: #1e5a85; padding: 8px;">
                                    <h5 class="mb-0 text-white">Detalles del Servicio a Contratar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <label class="w-100" for="date">Fecha de pago</label>
                                            <el-date-picker class="w-100" @change="calculePrice" v-model="pay_date"
                                                format="dd/MM/yyyy" value-format="yyyy-MM-dd"></el-date-picker>
                                        </div>
                                        <div class="col-md-6 mb-2" v-if="oldClient">
                                            <label class="w-100" for="date">Ultima mensualidad pagada</label>
                                            <el-date-picker class="w-100" v-model="paidDate" @change="updateEndOptions"
                                                format="dd/MM/yyyy" value-format="yyyy-MM-dd"></el-date-picker>
                                        </div>
                                        <div class="col-md-6 mb-2" v-if="!oldClient">
                                            <label class="w-100" for="date">Fecha de termino</label>
                                            <el-date-picker class="w-100" v-model="start_end" format="dd/MM/yyyy"
                                                value-format="yyyy-MM-dd"></el-date-picker>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <el-select v-model="form.plan_id" @change="changePrice"
                                                placeholder="Tipo de Plan">
                                                <el-option v-for="(data, idx) in plans" :key="idx"
                                                    :label="`${data.capacity} MB`" :value="data.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <el-select v-model="variationId" @change="calculateTotal"
                                                placeholder="Tarifa del Plan">
                                                <el-option v-for="(data, idx) in planVariations" :key="idx"
                                                    :label="`${data.description} S/.${data.price}`" :value="data.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <el-select v-model="concept.id" @change="changeConcept"
                                                placeholder="Selecionar Extras/Conceptos">
                                                <el-option v-for="(data, idx) in concepts" :key="idx"
                                                    :label="data.description" :value="data.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-md-5 mb-2">
                                            <!-- <label for="document type">Tarífa</label> -->
                                            <!-- <a
                                                v-if="concept.id"
                                                @click="openCreationForm('concept')"
                                                href="#"
                                                class="control-label font-weight-bold text-info"
                                            >
                                                [ + Nuevo]</a
                                            > -->
                                            <el-select v-model="variationConceptId" placeholder="Seleccionar Extra">
                                                <el-option v-for="(data, idx) in conceptVariations" :key="idx"
                                                    :label="`${data.description} S/.${data.price}`" :value="data.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-md-1 mt-sm-2  mb-sm-1 d-flex align-items-end">
                                            <el-tooltip content="Agregar Extra" placement="top">
                                                <el-button size="mini" type="primary" icon="el-icon-plus" circle
                                                    @click="addConcept"></el-button>
                                            </el-tooltip>
                                        </div>
                                        <div class="col-md-12 mt-1 table-responsive"
                                            v-if="conceptsSelected.length != 0">
                                            <table class="table  table-striped table-hover">
                                                <thead style="background-color: #073f68; color: #fff;">
                                                    <tr>
                                                        <th style="color: #fff">#</th>
                                                        <th style="color: #fff">Extra</th>
                                                        <th style="color: #fff">Descripción</th>
                                                        <th style="color: #fff">Total</th>
                                                        <th style="color: #fff"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(concept,
                                                        idx) in conceptsSelected" :key="idx">
                                                        <td>{{ idx + 1 }}</td>
                                                        <td>
                                                            {{ concept.generalConcept }}
                                                        </td>
                                                        <td>
                                                            {{ concept.description }}
                                                        </td>
                                                        <td>{{ concept.price }}</td>
                                                        <td>
                                                            <el-button @click="removeConcept(idx)" type="danger"
                                                                icon="el-icon-delete" circle></el-button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" v-if="form.number">
                                            <div class="col-md-12 mb-2">
                                                Datos de Facturación
                                            </div>
                                            <div class="col-md-4">
                                                <label for="doctype">Documento</label>
                                                <el-select @change="seriesByDocument" v-model="form.document_type_id">
                                                    <el-option v-for="(d, idx) in [
                                                        {
                                                            description: 'Factura',
                                                            value: '01',
                                                            visible:
                                                                form.number.length == 11 &&
                                                                !oldClient
                                                        },
                                                        {
                                                            description: 'Boleta',
                                                            value: '03',
                                                            visible:
                                                                form.number.length != 11 &&
                                                                !oldClient
                                                        },
                                                        {
                                                            description: 'Nota de venta',
                                                            value: '80',
                                                            visible: true
                                                        }
                                                    ]" :key="idx" v-show="d.visible" :label="d.description"
                                                        :value="d.value"></el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="doctype">Serie</label>
                                                <el-select v-model="form.serie_id" v-if="form.document_type_id">
                                                    <el-option v-for="(d, idx) in seriesDocument" :key="idx"
                                                        :label="d.number" :value="d.id"></el-option>
                                                </el-select>
                                                <el-input v-else class="w-100" :disabled="true">
                                                </el-input>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="doctype">Cobro de instalación</label>
                                                <el-input-number class="w-100" :controls="false"
                                                    v-model="form.install"></el-input-number>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-show="isVariationSelected">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header text-white" style="background-color: #1e5a85; padding: 8px;">
                                    <h5 class="mb-0 text-white">Datos de la Instalación</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-2">
                                                <el-select v-model="form.type" placeholder="Tipo de instalación">
                                                    <el-option label="Fibra" value="fibra"></el-option>
                                                    <el-option label="Antena" value="antena"></el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <el-input-number class="w-100" :controls="false"
                                                    v-model="form.identifier" :placeholder="'Id del Precinto'"
                                                    style="text-align: left; color: red;">
                                                </el-input-number>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <el-input v-model="form.mac"
                                                    placeholder="ingrese MAC del equipo"></el-input>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <el-input-number class="w-100" :controls="false" v-model="form.supplie"
                                                    :placeholder="'Nro de Suministro Eléctrico'">
                                                </el-input-number>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header text-white"
                                                    style="background-color: #073f68; padding: 3px;">
                                                    <h5 class="mb-0 text-white text-center">Imagen del Domicilio</h5>
                                                </div>
                                                <div class="card-body d-flex justify-content-center align-items-center">

                                                    <div class=""
                                                        style="max-width:300px;max-height:300px; min-height:100px;">
                                                        <img v-if="image" :src="image" alt="Vista previa de la imagen"
                                                            style="max-width: 200px; max-height: 100px;" />
                                                        <img v-else src="/images/imagen-no-disponible.jpg"
                                                            alt="Sin imagen"
                                                            style="max-width: 200px; max-height: 100px; opacity: 0.5;" />
                                                    </div>

                                                    <div class="d-flex">
                                                        <el-tooltip content="Subir imagen" placement="top"
                                                            v-if="!image">
                                                            <el-button class="m-2" type="success" icon="el-icon-upload"
                                                                circle @click="$refs.file.click()">
                                                            </el-button>
                                                        </el-tooltip>
                                                        <el-tooltip content="Eliminar imagen" placement="top" v-else>
                                                            <el-button class="m-2" type="danger" icon="el-icon-delete"
                                                                circle @click="image = null">
                                                            </el-button>
                                                        </el-tooltip>
                                                    </div>

                                                    <p style="font-size: 9px; margin-top: 0;"><em>JPG, PNG, JPEG</em>
                                                    </p>
                                                    <input accept="image/png, image/jpeg, image/jpg" type="file"
                                                        @change="changeImage" ref="file" style="display: none" />

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="document type">
                                                    <i class="fas fa-user-cog mr-1"></i>
                                                    Técnico Responsable
                                                </label>
                                                <a @click="openCreateTechForm" href="#"
                                                    class="control-label font-weight-bold text-info">
                                                    [ + Nuevo]</a>
                                                <el-select filterable clearable v-model="form.tech_id">
                                                    <el-option v-for="(data, idx) in techs" :key="idx"
                                                        
                                                        :label="data.person.name" :value="data.id">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="w-100" for="date">Fecha de instalación</label>
                                                <el-date-picker class="w-100" v-model="start_date"
                                                    @change="updateEndOptions" format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"></el-date-picker>
                                            </div>

                                            <div class="col-md-12  mb-2">
                                                <el-input v-model="form.address" key="address"
                                                    placeholder="Dirección de instalación">
                                                </el-input>
                                            </div>
                                            <div class="col-md-12  mb-2">

                                                <el-input v-model="form.address_reference" placeholder="Referencia">
                                                </el-input>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="document type">Equipos a Utilizar</label>
                                                <el-select class="w-100" v-model="item.id" filterable remote
                                                    popper-class="el-select-customers" clearable
                                                    placeholder="Nombre o código interno"
                                                    :remote-method="searchRemoteItems" :loading="loading_search_item"
                                                    @change="changeItem">
                                                    <el-option v-for="option in items" :key="option.id"
                                                        :value="option.id" :label="option.description"></el-option>
                                                </el-select>
                                                <el-button v-if="showSeries" size="mini" type="primary"
                                                    @click="openModalSeries">
                                                    Elegir series
                                                </el-button>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="document type">Cantidad</label>
                                                <el-input :disabled="showSeries" v-model="item.quantity">
                                                </el-input>
                                            </div>
                                            <div :class="`col-md-1 d-flex 
                                                            mt-sm-2  mb-sm-1 ${showSeries
                                                    ? 'align-items-center'
                                                    : 'align-items-end'
                                                }`
                                                ">
                                                <el-tooltip content="Agregar equipos a utilizar" placement="top">
                                                    <el-button size="mini" type="primary" icon="el-icon-plus" circle
                                                        @click="addItem">
                                                    </el-button>
                                                </el-tooltip>
                                                <small v-if="showSeries"> </small>
                                            </div>
                                            <div class="col-md-12  mt-1 table-responsive"
                                                v-if="itemsSelected.length != 0">
                                                <table class="table  table-striped table-hover">
                                                    <thead style="background-color: #073f68; color: #fff;">
                                                        <tr>
                                                            <th style="color: #fff">#</th>
                                                            <th style="color: #fff">Descripción</th>
                                                            <th style="color: #fff">Cantidad</th>
                                                            <th style="color: #fff">Series</th>
                                                            <th style="color: #fff"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, idx) in itemsSelected" :key="idx">
                                                            <td>{{ idx + 1 }}</td>
                                                            <td>
                                                                {{ item.description }}
                                                                <template v-if="item.series.length != 0">
                                                                    <div v-for="serie in item.series" :key="serie.id">
                                                                        <small>
                                                                            {{
                                                                                serie.series
                                                                            }}</small>
                                                                    </div>
                                                                </template>
                                                            </td>
                                                            <td>{{ item.quantity }}</td>
                                                            <td>
                                                                <el-button @click="removeItem(idx)" type="danger"
                                                                    icon="el-icon-delete" circle></el-button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- <div class="row mt-2">
                        <div class="col-md-4">
                            <span class="h5">
                                INSTALACION S/.
                                {{
                                    this.form.install
                                        ? this.form.install.toFixed(2)
                                        : 0.0
                                }}
                            </span>
                            <span class="h5" :class="installMonthly ? '' : 'text-danger'">
                                MENSUALIDAD S/.
                                {{
                                    this.form.total
                                        ? this.form.total.toFixed(2)
                                        : 0.0
                                }}
                                {{ days != 0 ? " x " + days + " días" : "" }}
                            </span>
                            <br />

                            <br />
                            <span class="h4">
                                TOTAL S/.
                                <template v-if="installMonthly">
                                    {{
                                        (
                                            Number(
                                                this.form.install
                                                    ? this.form.install
                                                    : 0.0
                                            ) +
                                            Number(
                                                this.form.total
                                                    ? this.form.total
                                                    : 0.0
                                            )
                                        ).toFixed(2)
                                    }}</template>
                                <template v-else>
                                    {{
                                        Number(
                                            this.form.install
                                                ? this.form.install
                                                : 0.0
                                        ).toFixed(2)
                                    }}
                                </template>
                            </span>
                        </div>
                        <div class="col-md-8 d-flex justify-content-end align-items-end">
                            <div slot="footer" class="dialog-footer">
                                <el-checkbox v-if="!oldClient" v-model="installMonthly">Cobrar mensualidad</el-checkbox>
                                <el-button @click="close">Cancelar</el-button>
                                <el-button type="primary" @click="sendRegister">Registrar</el-button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <cash-form :showDialog.sync="showDialogCash" :recordId="cash_id" :fromBox="true"
                @updateCashId="updateCashId"></cash-form>
            <close-cash :recordId.sync="cash_id" :showDialogClose.sync="showDialogClose" :fromBox="true"
                @updateCashId="updateCashId">
            </close-cash>
            <expenses-incomes :showDialog.sync="showExpensesIncomes" :company="company" :cash_id="cash_id">
            </expenses-incomes>
            <!-- <observation-form
            :current="current"
            :observations.sync="tags"
            :showDialog.sync="showObservations"
            @addObservation="addObservation"
        >
        </observation-form> -->
            <show-series-product :limitQty="limitQty" :idx="currentIdx" :item="currentItem"
                :showDialog.sync="showModalSeries" :seriesSelected.sync="currentSeries" @updateSeries="updateSeries">
            </show-series-product>
        </div>
        <create-variation-form :showDialog.sync="showFormVariation" :dataVariation="variationData"
            @addVariation="addVariation"></create-variation-form>
        <payment-internet :serviceItem="serviceItem" :configuration="configuration" @getRegisters="getRegisters"
            :paymentItems="paymentItems" :data.sync="data" :is_payment.sync="is_payment"
            :periodObservation="observation" @addAdvance="addAdvance">
        </payment-internet>
        <person-form :newTech="newTech" :external="true" :showDialog.sync="showDialogNewPerson"></person-form>
        <transfers-modal :showDialog.sync="showTransfersDialog"></transfers-modal>
    </div>
</template>
<style>
.el-input-group__prepend {
    padding-left: 6px !important;
    padding-right: 6px !important;
}

.custom_input .el-input__inner {
    padding: 0 5px !important;
}

.el-tag+.el-tag {
    margin-left: 10px;
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag1 {
    width: 70px;
    margin-left: 10px;
    vertical-align: bottom;
}

.input-new-tag1 .el-input__inner {
    height: 30px !important;
}
</style>
<script>
import moment from "moment";
const PaymentInternet = () => import("./payment_internet.vue");
/* import CashForm from "../../cash/form.vue";
import CloseCash from "../../cash/closecash.vue";
import OrdenPullApart from "./ordens_pull_apart.vue";
import TableOrdensPending from "./list_pending_ordens.vue";
import ObservationForm from "../../partials/observation_form.vue"; */
const CreateVariationForm = () => import("./create_variation_form.vue");
const CashForm = () => import("../../cash/form.vue");
const CloseCash = () => import("../../cash/closecash.vue");
// const OrdenPullApart = () => import("./ordens_pull_apart.vue");
// const TableOrdensPending = () => import("./list_pending_ordens.vue");
// const ObservationForm = () => import("../../partials/observation_form.vue");
const ExpensesIncomes = () => import("../partials/expenses_incomes.vue");
const ShowSeriesProduct = () => import("../partials/show_series_product.vue");
// const ShowLotesProduct = () => import("../partials/show_lotes_product.vue");
const TransfersModal = () => import("../partials/transfer_modal.vue");
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    components: {
        PersonForm,
        CreateVariationForm,
        CashForm,
        CloseCash,
        PaymentInternet,
        // TableOrdensPending,
        // OrdenPullApart,
        // ObservationForm,
        ExpensesIncomes,
        ShowSeriesProduct,
        // ShowLotesProduct,
        TransfersModal
    },
    props: [
        "identityDocuments",
        "company",
        "customer_variation",
        "variationShow",
        "establishments",
        "itemDefault",
        "ordensPending",
        "area_id",
        "blockCart",
        "localOrden",
        "configuration",
        "ordens",
        "total2",
        "clientTableData",
        "isCreatingOrden",
        "ordenId",
        "cash_id",
        "series"
    ],

    data() {
        return {
            zones: [],
            imageSaved: null,
            days: 0,
            pay_date: moment().format("YYYY-MM-DD"),
            paidDate: null,
            oldClient: false,
            showRegister: true,
            techs: [],
            newTech: false,
            showDialogNewPerson: false,
            is_payment: false,
            installMonthly: false,
            item: {},
            limitQty: 0,
            showFormVariation: false,
            showTransfersDialog: false,
            descriptionTemp: null,
            showChangeDescriptionVariation: false,
            variation: false,
            showObservations: false,
            boxOperation: "Abrir",
            showDialogCash: false,
            tags: [],
            showSeries: false,
            current: null,
            showDialogClose: false,
            showPendingOrdens: false,
            ordenLoading: false,
            listApart: false,
            apart: false,
            numberCustomerApart: null,
            ordenInBox: [],
            pin: "",
            totalOrdenItems: 0.0,
            total: 0.0,
            disableSend: false,
            totalOrden: 0.0,
            loading: false,
            commands_fisico: "",
            AllSelected: false,
            showDialogPing: false,
            dialogLocalObservation: false,
            currentLocalOrden: null,
            localObservation: null,
            dialogObservation: false,
            observation: null,
            loadingObservation: false,
            currentOrden: null,
            form_ped: {},
            to_carry: false,
            optionsMenu: [],
            foodDefault: null,
            showExpensesIncomes: false,
            showLotes: false,
            ordenLot: null,
            currentIdx: null,
            currentItem: null,
            currentSeries: [],
            screenWidth: 0,
            printing: false,
            form: {
                address: null,
                address_reference: null,
                name: null,
                telephone: null,
                install: 0
            },
            loading_search: false,
            timer: null,
            image: null,
            currentCustomer: null,
            plans: [],
            concepts: [],
            planVariations: [],
            conceptVariations: [],
            variationId: null,
            concept: {},
            loading_search_item: false,
            variationConceptId: null,
            conceptsSelected: [],
            items: [],
            variationData: {},
            showSeries: false,
            showModalSeries: false,
            itemsSelected: [],
            start_date: moment().format("YYYY-MM-DD"),
            start_date_migration: moment().format("YYYY-MM-DD"),
            start_end: null,
            seriesDocument: [],

            pickerStartOptions: {
                disabledDate(time) {
                    return time < Date.now();
                }
            },
            pickerEndOptions: {
                disabledDate(time) {
                    return time.getTime() < Date.now();
                }
            },
            data: null,
            paymentItems: [],
            serviceItem: null,
            phone: null,
            formattedMac: ''
        };
    },

    watch: {
        cash_id(newCash, _) {
            this.boxOperation = newCash ? "Cerrar" : "Abrir";
            this.optionsMenu[2].title = [this.boxOperation, " Caja"];
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
        this.foodDefault = this.itemDefault;
        this.boxOperation = this.cash_id ? "Cerrar" : "Abrir";

        this.optionsMenu = [
            {
                id: 1,
                title: ["Configuración"],
                icon: "fas fa-cogs",
                visible: false
            },
            {
                id: 2,
                title: ["Recibir ", "mercaderia"],
                icon: "fas fa-people-carry",
                visible:
                    !this.configuration.college &&
                    this.configuration.receive_merchandise
            },
            {
                id: 3,
                title: [this.boxOperation, " Caja"],
                icon: "fas fa-cash-register",
                visible: true
            },
            {
                id: 7,
                title: ["Ingresos y Gastos"],
                icon: "fas fa-money-bill-wave-alt",
                visible: true
            },
            /* {
                id: 4,
                title: ["Aparcado"],
                icon: "fas fa-cart-arrow-down",
                visible: !this.configuration.college
            }, */

            {
                id: 5,
                title: ["Ordenes"],
                icon: "fas fa-hourglass",
                visible:
                    this.configuration.restaurant && !this.configuration.college
            }
        ];
        let ordens = [];
        let ordensSave = localStorage.ordens;
        if (ordensSave) {
            ordens = JSON.parse(ordensSave);
        }
        this.ordenInBox = ordens;
    },
    async created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
        await this.getTables();
        let printing = localStorage.getItem("cajaPrint");

        this.printing = printing == 1;
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });
    },
    methods: {
        setStartDate() {
            if (this.oldClient == false) {
                this.start_date = moment().format("YYYY-MM-DD");
            }
        },
        trigerFunction(id) {
            switch (id) {
                case 7:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                    } else {
                        this.showExpensesIncomes = true;
                    }
                    break;
                case 2:
                    this.showTransfers();
                    break;
                case 3:
                    if (this.cash_id) {
                        this.showDialogClose = true;
                    } else {
                        this.showDialogCash = true;
                    }
                    break;
                case 5:
                    this.showOrdensPending();
                    break;
                case 4:
                    if (this.ordenInBox.length > 0) {
                        this.listApart = true;
                    } else {
                        this.$toast.warning("Sin ventas apartacadas.");
                    }
                    break;

                default:
                    //naa
                    break;
            }
        },
        showTransfers() {
            this.showTransfersDialog = true;
        },
        transformMac(mac) {
            // Eliminar todo lo que no sea alfanumérico
            mac = (mac || '').replace(/[^a-zA-Z0-9]/g, '').slice(0, 12);
            // Agrupar en pares
            let pairs = [];
            for (let i = 0; i < mac.length; i += 2) {
                pairs.push(mac.substr(i, 2));
            }
            const formatedMac = pairs.join(":");
            this.form.mac = formatedMac;
            // Formatear para mostrar los : de otro color y con espacio antes y después
            this.formattedMac = formatedMac
                .split("")
                .map(char => {
                    if (char === ":") {
                        return '<span style="color: #ff6600; font-weight:bold; margin: 0 4px;"> : </span>';
                    } else {
                        return char;
                    }
                })
                .join("");
        },
        async changeImage() {
            let files = this.$refs.file.files;
            if (files.length > 0) {
                let file = files[0];
                const formData = new FormData();
                formData.append("file", file);
                try {
                    let reader = new FileReader();

                    reader.onload = e => {
                        this.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } catch (e) {
                    console.log(e);
                }
            }
        },
        addAdvance(advance) {
            this.data.advance = advance;
        },
        calculePrice() {
            this.days = 0;
            if (moment(this.start_date).isAfter(this.pay_date)) {
                this.$toast.error(
                    "La fecha de inicio no puede ser mayor a la fecha de pago"
                );
                this.pay_date = this.start_date;
                return;
            }

            let pay_date = moment(this.pay_date);
            let start_date = moment(this.start_date);
            if (
                pay_date.diff(start_date, "months") > 0 &&
                pay_date.date() != start_date.date()
            ) {
                this.$toast.error(
                    "La diferencia entre la fecha de inicio y la fecha de pago no puede ser mayor a un mes"
                );
                this.pay_date = this.start_date;
                return;
            }
            let days = moment(this.pay_date).diff(this.start_date, "days");
            let plan = this.plans.find(plan => plan.id == this.form.plan_id);
            if (plan) {
                let planVariation = this.planVariations.find(
                    variation => variation.id == this.variationId
                );
                if (planVariation) {
                    let price = Number(planVariation.price);
                    //create a conceptPrice for each concept of conceptSelected and get the sum of price
                    let conceptPrice = 0;
                    this.conceptsSelected.forEach(concept => {
                        conceptPrice += Number(concept.price);
                    });
                    let totalPrice = price + conceptPrice;
                    if (days != 0 && !isNaN(totalPrice)) {
                        totalPrice = (totalPrice / 30) * days;
                        this.days = days;
                    }
                    this.form.total = Number(totalPrice);
                    this.$forceUpdate();
                }
            }
        },
        cleanForm() {
            this.image = null;
            this.installMonthly = false;
            this.form = {
                zone_id: null,
            };
            this.phone = null;
            this.concept = {};
            this.variationId = null;
            this.variationConceptId = null;
            this.itemsSelected = [];
            this.conceptsSelected = [];
            this.start_date = moment().format("YYYY-MM-DD");
            this.start_end = null;
            this.concept.id = null;
            this.oldClient = false;
            this.paidDate = null;
            this.days = 0;
        },
        getRegisters() {
            this.cleanForm();
            this.$emit("getRecords");
        },
        async getTechs() {
            const response = await this.$http.get(`/internet/techs`);

            const { techs } = response.data;
            this.techs = techs ?? [];
        },
        async reloadDataCustomers(id) {
            if (this.newTech) {
                const response = await this.$http.get(
                    `/internet/create_tech/${id}`
                );
                if (response.status == 200) {
                    const { data } = response;
                    const { id } = data;
                    await this.getTechs();
                    this.form.tech_id = id;
                    this.$forceUpdate();
                }
            } else {
                const response = await this.$http.get(
                    `/documents/search/customer/${id}`
                );
                const { customers } = response.data;
                let [customer] = customers;
                this.form.number = customer.number;
                this.form.name = customer.name;
                this.phone = customer.phone;
                this.form.address = customer.address;
                this.form.person_id = customer.id;
                // Solo asignar zone_id si no ha sido seleccionado manualmente
                if (!this.form.zone_id) {
                    this.form.zone_id = customer.client_zone_id !== null ? customer.client_zone_id : null;
                }
                this.form.identity_document_type_id = customer.identity_document_type_id;
            }
        },
        async createTech(id) {
            const response = await this.$http(`internet/create_tech/${id}`);
        },
        openCreateTechForm() {
            this.newTech = true;
            this.showDialogNewPerson = true;
        },
        openCreatePersonForm() {
            this.newTech = false;
            this.showDialogNewPerson = true;
        },
        deepCopy(obj) {
            if (obj === null || typeof obj !== "object") {
                return obj;
            }

            let copy;

            if (obj instanceof Array) {
                copy = [];
                for (let i = 0; i < obj.length; i++) {
                    copy[i] = this.deepCopy(obj[i]);
                }
            } else {
                copy = {};
                for (let key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        copy[key] = this.deepCopy(obj[key]);
                    }
                }
            }

            return copy;
        },
        initItems() {
            let items = [];
            if (this.form.install && this.serviceItem) {
                let serviceItem = this.deepCopy(this.serviceItem);
                serviceItem.sale_unit_price = this.form.install;

                serviceItem.percentage_igv = 18;
                serviceItem.descriptionInternet = "Instalación";

                items.push(serviceItem);
            }
            if (this.installMonthly) {
                let plan = this.planVariations.find(
                    p => p.id == this.variationId
                );
                if (plan) {
                    let generalPlan = this.plans.find(
                        p => p.id == plan.plan_id
                    );
                    if (generalPlan) {
                        let itemPlan = this.deepCopy(generalPlan.item);
                        itemPlan.sale_unit_price = plan.price;
                        itemPlan.percentage_igv = 18;
                        itemPlan.descriptionInternet = `Plan ${generalPlan.capacity} - ${plan.description}`;
                        itemPlan.descriptionInternet = `${itemPlan.descriptionInternet
                            } - ${this.generatePeriod()}`;
                        items.push(itemPlan);
                    }
                }

                for (let cp of this.conceptsSelected) {
                    let generalConcept = this.concepts.find(
                        c => c.id == cp.concept_id
                    );

                    if (generalConcept) {
                        let itemConcept = this.deepCopy(generalConcept.item);
                        itemConcept.sale_unit_price = cp.price;

                        itemConcept.percentage_igv = 18;
                        itemConcept.descriptionInternet = `${generalConcept.description}-  ${cp.description} -                     
                        `;
                        items.push(itemConcept);
                    }
                }
            }

            this.paymentItems = items;
        },
        generatePeriod() {
            if (
                moment(this.start_date).format("YYYY-MM-DD") ==
                moment(this.pay_date).format("YYYY-MM-DD")
            ) {
                return `${moment(this.start_date).format(
                    "DD/MM/YYYY"
                )} - ${moment(this.start_date)
                    .add(1, "month")
                    .format("DD/MM/YYYY")}`;
            } else {
                return `${moment(this.start_date).format(
                    "DD/MM/YYYY"
                )} - ${moment(this.pay_date).format("DD/MM/YYYY")}`;
            }
        },
        showPayment() {
            this.is_payment = true;
        },
        setSaleNote() {
            this.form.document_type_id = "80";
            this.seriesByDocument();
            this.form.serie_id = this.seriesDocument.find(
                s => s.document_type_id == "80"
            ).id;
        },
        async sendRegister() {
            let hasError = this.validate();
            if (hasError) return;

            if (this.form.install == 0 && this.installMonthly == false) {
                this.setSaleNote();
            }

            this.form.installItems = this.itemsSelected;
            this.form.concepts = this.conceptsSelected;
            this.form.plan_variation_id = this.variationId;
            this.form.plan = this.plans.find(p => p.id == this.form.plan_id);
            this.form.plan_variation = this.planVariations.find(
                p => p.id == this.variationId
            );
            this.data = this.form;
            if (this.image) {
                this.data.image = this.image;
            }
            this.data.date = this.start_date;
            this.data.phone = this.phone;
            this.data.end_date = this.start_end;
            this.data.payMonth = this.installMonthly;
            this.data.paidDate = this.paidDate;
            this.data.pay_date = this.pay_date;
            this.data.oldClient = this.oldClient;
            this.initItems();
            let startDate = moment(this.start_date);
            let payDate = moment(this.pay_date);
            if (this.start_date != this.pay_date) {
                this.observation = `SE REGISTRÓ PAGO DEL SERVICIO CON FECHA DE INICIO ${startDate.format(
                    "DD/MM/YYYY"
                )} HASTA LA FECHA ${payDate.format("DD/MM/YYYY")}`;
            } else {
                this.observation = `SE REGISTRÓ PAGO DEL SERVICIO CON FECHA DE INICIO ${startDate.format(
                    "DD/MM/YYYY"
                )} HASTA LA FECHA ${startDate
                    .add(1, "months")
                    .format("DD/MM/YYYY")}`;
            }
            if (this.days > 0) {
                let plan_concept = this.paymentItems.find(
                    p => p.descriptionInternet != "Instalación"
                );
                let installation = this.paymentItems.find(
                    p => p.descriptionInternet == "Instalación"
                );
                if (plan_concept.sale_unit_price != this.form.total) {
                    plan_concept.sale_unit_price = this.form.total;
                }
                this.paymentItems = [installation, plan_concept];
            }
            this.is_payment = true;
            return;
        },
        updateEndOptions() {
            if (this.start_date) {
                if (!this.oldClient) {
                    let startDate = new Date(this.start_date);
                    if (startDate.getTime() < new Date().getTime() - 86400000) {
                        this.$toast.error(
                            "La fecha de inicio no puede ser anterior al día actual"
                        );
                        this.start_date = moment().format("YYYY-MM-DD");
                    }
                }

            }
        },
        validEndDate(time) {
            return time.getTime();
        },
        async updateCashId(id) {
            this.$emit("update:cash_id", id);
        },

        validate() {
            let fail = false;

            let errors = {
                person_id: "El cliente debe ser creado",
                identity_document_type_id:
                    "El documento de identidad es obligatorio",
                number: "El número del documento es obligatorio",
                name: "El nombre del cliente es obligatorio",
                type: "El tipo de instalación es obligatorio",
                mac: "La MAC es obligatoria",
                plan_id: "El plan es obligatorio",
                address: "La dirección es obligatoria",
                document_type_id: "El documento a emitir es obligatorio",
                serie_id: "La serie es obligatoria",
                tech_id: "El técnico es obligatorio",
                identifier: "El id es obligatorio",
                supplie: "El suministro eléctrico es obligatorio",
                tech_id: "El técnico es obligatorio"
            };
            if (!this.phone) {
                fail = true;
                this.$toast.error("El teléfono es obligatorio");
            } else {
                if (this.phone.length != 9) {
                    fail = true;
                    this.$toast.error("El teléfono debe tener 9 dígitos");
                }
            }
            for (let error of Object.keys(errors).reverse()) {
                if (!this.form[error]) {
                    fail = true;
                    this.$toast.error(errors[error]);
                }
            }
            if (this.form.mac) {
                let mac = this.form.mac;
                mac = mac.split(":");
                if (mac.length != 6) {
                    fail = true;
                    this.$toast.error(
                        "La MAC debe tener 6 pares de caracteres separados por dos puntos (:)"
                    );
                } else {
                    for (let i = 0; i < mac.length; i++) {
                        if (mac[i].length != 2) {
                            fail = true;
                            this.$toast.error(
                                "La MAC debe tener 6 pares de caracteres separados por dos puntos (:)"
                            );
                        }
                    }
                }
            }
            if (this.form.supplie) {
                if (Number.isNaN(this.form.supplie)) {
                    fail = true;
                    this.$toast.error("El suministro debe ser numérico");
                }

                if (this.form.supplie.toString().length != 8) {
                    fail = true;
                    this.$toast.error("El suministro debe tener 8 dígitos");
                }
            }
            if (!this.variationId) {
                fail = true;
                this.$toast.error("El precio del plan es obligatorio");
            }

            if (this.itemsSelected.length == 0) {
                fail = true;
                this.$toast.error(
                    "Ingrese el equipo usado para la instalación"
                );
            }
            if (this.start_date != null) {
                let past = moment(this.start_date).isBefore(
                    moment().set({
                        hour: 0,
                        minute: 0,
                        second: 0,
                        millisecond: 0
                    })
                );
                // if (past) {
                //     fail = true;
                //     this.$toast.error(
                //         "La fecha de inicio no puede ser anterior al día actual"
                //     );
                // }
                if (this.start_end) {
                    let startGreater =
                        moment(this.start_date) > moment(this.start_end);

                    if (startGreater) {
                        fail = true;
                        this.$toast.error(
                            "La fecha final no puede ser anterior a la fecha de inicio"
                        );
                    }
                }
                if (this.oldClient) {
                    if (!this.paidDate) {
                        fail = true;
                        this.$toast.error(
                            "La fecha de la ultima mensualidad es obligatoria"
                        );
                    }
                }
                if (this.paidDate && this.oldClient) {
                    let startGreater =
                        moment(this.start_date) > moment(this.paidDate);

                    if (startGreater) {
                        fail = true;
                        this.$toast.error(
                            "La fecha de la ultima mensualidad no puede ser anterior a la fecha de inicio"
                        );
                    }

                    if (
                        moment(this.start_date).date() !=
                        moment(this.paidDate).date()
                    ) {
                        fail = true;
                        this.$toast.error(
                            "Coloque los mismos DÍAS para la fecha de inicio y ultima mensualidad"
                        );
                    }
                }
            } else {
                fail = true;
                this.$toast.error("La fecha de inicio es obligatoria.");
            }
            if (this.pay_date == null) {
                fail = true;
                this.$toast.error("La fecha de pago es obligatoria.");
            }
            //tipo documento, nombre, document,
            //tipo, mac/id, tipo plan, precio,
            //direccion
            //equipo
            //fecha de inicio
            //documento serie instalacion

            return fail;
        },
        seriesByDocument() {
            let { document_type_id } = this.form;
            if (document_type_id) {
                this.seriesDocument = this.series.filter(
                    s => s.document_type_id == document_type_id
                );
                if (this.seriesDocument.length != 0) {
                    this.form.serie_id = this.seriesDocument[0].id;
                }
            }
        },
        removeItem(idx) {
            this.itemsSelected.splice(idx, 1);
        },
        removeConcept(idx) {
            this.conceptsSelected.splice(idx, 1);
            this.calculateTotal();
        },
        addItem() {
            let { quantity } = this.item;
            if (!quantity) {
                return this.$toast.error("Ingrese una cantidad válida");
            }
            let { id, description } = this.currentItem;
            this.itemsSelected = this.itemsSelected.filter(i => i.id != id);
            this.itemsSelected.push({
                id,
                description,
                quantity,
                series: this.currentSeries
            });
            this.showSeries = false;
            this.item = {};
        },
        updateSeries(idx, series) {
            this.item.quantity = series.length;
            this.currentSeries = series;
        },
        openModalSeries() {
            this.showModalSeries = true;
        },
        addVariation(form) {
            let { type } = form;
            if (type == "plan") {
                let [plan] = this.plans.filter(p => p.id == this.form.plan_id);
                plan.variations = [...plan.variations, form];
                this.planVariations = plan.variations;
            } else {
                let [concept] = this.concepts.filter(
                    p => p.id == this.concept.id
                );
                concept.variations = [...concept.variations, form];
                this.conceptVariations = concept.variations;
            }
        },
        openCreationForm(type) {
            this.variationData = {
                type,
                typeId: type == "plan" ? this.form.plan_id : this.concept.id
            };
            this.showFormVariation = true;
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        changeItem() {
            this.currentSeries = [];
            let item = this.items.find(i => i.id == this.item.id);
            this.currentItem = item;
            let { series_enabled } = item;
            this.showSeries = !!series_enabled;
        },
        addConcept() {
            let [concept] = this.conceptVariations.filter(
                cv => cv.id == this.variationConceptId
            );

            if (concept) {
                let { concept_id } = concept;
                let { description } = this.concepts.find(
                    c => c.id == concept_id
                );
                this.conceptsSelected = this.conceptsSelected.filter(
                    i => i.concept_id != concept.id
                );
                this.conceptsSelected.push({
                    ...concept,
                    generalConcept: description
                });
            }
            this.calculateTotal();
        },
        changeConcept() {
            let [concept] = this.concepts.filter(p => p.id == this.concept.id);

            this.conceptVariations = concept.variations;

            if (this.conceptVariations.length != 0) {
                this.variationConceptId = this.conceptVariations[0].id;
            } else {
                this.variationConceptId = null;
            }
        },
        changePrice() {
            let [plan] = this.plans.filter(p => p.id == this.form.plan_id);

            this.form.plan_price = plan.default_price;
            this.planVariations = plan.variations;

            if (this.planVariations.length != 0) {
                this.variationId = this.planVariations[0].id;
            } else {
                this.variationId = null;
            }
            this.calculateTotal();
        },
        async getTables() {
            try {
                const response = await this.$http("/internet/tables");
                const {
                    plans,
                    concepts,
                    items,
                    service_item,
                    techs,
                    zones
                } = response.data;
                this.zones = zones ?? [];
                this.plans = plans ?? [];
                this.concepts = concepts ?? [];
                this.items = items ?? [];
                this.techs = techs ?? [];
                this.serviceItem = service_item;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async searchPerson() {
            let documentNumber = this.form.number;

            if (documentNumber == null || documentNumber == "") return;
            // if (documentNumber.length != 8 && documentNumber.length != 11) {
            //     this.$toast.error("Ingrese un documento válido");
            //     return;
            // }
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                try {
                    this.currentCustomer = null;
                    this.loading_search = true;
                    const response = await this.$http(
                        `/internet/persons/${documentNumber}`
                    );
                    const { success, data } = response.data;
                    if (success) {
                        this.form.person_id = data.id;
                        this.form.name = data.name;
                        this.phone = data.telephone;
                        this.form.address = data.address;
                        this.form.zone_id = data.client_zone_id;
                    } else {
                        this.$toast.error("Verifique los datos.");
                    }
                } catch (e) {
                    this.$toast.error("No se pudo obtener los datos");
                } finally {
                    this.loading_search = false;
                }
            }, 250);
        },

        handleResize() {
            this.screenWidth = window.innerWidth;
            if (this.screenWidth >= 768) {
                this.showRegister = true;
            }
        },

        justNumber(indexx) {
            this.localOrden[indexx].newSubtotal = this.localOrden[
                indexx
            ].newSubtotal.replace(/[^0-9.]/g, "");
        },

        close() {
            this.$emit("update:localOrden", []);
        },
        update_price(index, sale_unit_price) {
            let localOrden_update = this.localOrden;
            localOrden_update[index].food.sale_unit_price = sale_unit_price;
            this.$emit("update:localOrden", localOrden_update);
            this.calculateTotal();
        },

        async printTicket(id) {
            try {
                const response = await this.$http.get(
                    `/restaurant/worker/record/${id}`
                );
                let url = response.data.print;

                let config = qz.configs.create(response.data.printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: url
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });

                //this.$toast.success("se esta imprimiendo el comprobante con exito");
                // qz.websocket.disconnect()
            } catch (e) {
                this.$toast.error(e.message);
            }
        },

        view_orders() {
            $(".style-switcher")
                .animate(
                    {
                        right: "0"
                    },
                    300
                )
                .addClass("active");
        },

        closeDialog(ordenId = null) {
            let ordenToAdd = [...this.localOrden];
            ordenToAdd = ordenToAdd.map(o => ({
                status_orden_id: 1,
                food: {
                    description: o.food.description,
                    price: o.food.price
                },
                observations: o.observation
            }));
            // let allOrdens = [...ordenToAdd, ...this.ordens];
            this.$emit("updateOrdens", ordenId);
            this.$emit("listtables");
            // this.$emit("update:ordens", allOrdens);
            this.$emit("update:localOrden", []);
            this.$eventHub.$emit("reloadData");
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
        },
        clear_command() {
            this.commands_fisico = null;
        },
        checkIsExistSerie() {
            let hasError = false;
            for (let ord of this.localOrden) {
                let { series_enabled } = ord.food.item;

                if (series_enabled && ord.series.length == 0) {
                    hasError = true;
                    break;
                }
            }
            return hasError;
        },
        async payOrden() {
            if (this.checkIsExistSerie()) {
                this.$toast.error("Producto sin serie seleccionada");
                return;
            }
            if (!this.cash_id) {
                this.$toast.error("No tiene una caja abierta");
                return;
            }
            if (this.clientTableData.table) {
                if (this.ordens.length == 0) {
                    this.$toast.warning("Orden sin productos");
                    return;
                }
            } else {
                if (this.localOrden.length == 0 && !this.variation) {
                    this.$toast.warning("Orden sin productos");
                    return;
                }
            }

            this.disableSend = true;
            let form_submit = {
                id: null,
                caja: true,
                printDocument: this.printing,
                printing: this.configuration.print_commands,
                commands_fisico: this.commands_fisico,
                print_kitchen: this.configuration.print_kitchen,
                to_carry: this.to_carry,
                orden: {
                    table_id: 1,
                    status_orden_id: 1
                },
                //enviar las ordenes a cobrar
                //  items: this.ordens,
                // items: this.localOrden,
                pin: null
            };
            if (this.clientTableData.table) {
                form_submit.items = this.ordens;
            } else {
                form_submit.items = this.localOrden;
            }
            this.loading = true;
            // const responses = await this.$http.post(
            //     "/restaurant/worker/send-orden",
            //     form_submit
            // );

            this.commands_fisico = "";
            this.to_carry = false;
            //    let IdOrdensend = responses.data.id;
            //    if (responses.data.success == true) {

            this.loading = false;
            // this.$toast.success(responses.data.message);
            this.disableSend = false;
            //      document.querySelector("#close_offcanvas").click();
            // } else {
            //     this.loading = false;
            //     this.$toast.error(responses.data.message);
            // }
            if (this.variation) {
                form_submit.variationItems = this.foodDefault;
            }
            this.loading = false;
            this.disableSend = false;
            if (this.variation) {
                this.$emit("paymentsOrden", form_submit, this.foodDefault);
            } else {
                this.$emit("paymentsOrden", form_submit);
            }
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },

        calculateTotal() {
            let total = 0;
            let plan = this.planVariations.find(p => p.id == this.variationId);
            if (plan) {
                total += Number(plan.price);
            }

            let totalConcept = this.conceptsSelected.reduce(
                (a, b) => a + Number(b.price),
                0
            );

            total += totalConcept;

            this.form.total = total;
            this.calculePrice();
        },
        updateMacVisual(mac) {
            // Solo actualiza el formato visual y el contador, no modifica el valor del input
            const visual = (mac || '').replace(/[^a-zA-Z0-9]/g, '').slice(0, 12);
            let pairs = [];
            for (let i = 0; i < visual.length; i += 2) {
                pairs.push(visual.substr(i, 2));
            }
            const formatedMac = pairs.join(":");
            this.formattedMac = formatedMac
                .split("")
                .map(char => {
                    if (char === ":") {
                        return '<span style="color: #ff6600; font-weight:bold; margin: 0 4px;"> : </span>';
                    } else {
                        return char;
                    }
                })
                .join("");
        },
        formatMacOnBlur() {
            // Al salir del input, formatea y actualiza el valor real
            let mac = (this.form.mac || '').replace(/[^a-zA-Z0-9]/g, '').slice(0, 12);
            let pairs = [];
            for (let i = 0; i < mac.length; i += 2) {
                pairs.push(mac.substr(i, 2));
            }
            this.form.mac = pairs.join(":");
            this.updateMacVisual(this.form.mac);
        }
    },
    computed: {
        macCharCount() {
            // Cuenta solo los caracteres alfanuméricos (sin los dos puntos)
            return (this.form.mac || '').replace(/[^a-zA-Z0-9]/g, '').length;
        },
        isVariationSelected() {
            return this.variationId !== null && this.variationId !== undefined && this.variationId !== '';
        }
    }
};
</script>
