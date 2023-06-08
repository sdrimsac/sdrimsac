<template>
    <div class="x-form-group" :class="{'text-danger': error && error.length}">
        <label class="x-control-label" v-if="label">
            {{ label }}
            <slot name="label-action"></slot>
        </label>
        <div class="x-control-input">
            <slot></slot>
        </div>
        <small class="x-form-control-feedback" v-if="error && error.length" > <i class="el-icon-error"></i> {{error[0]}} </small>
    </div>
</template>

<style>
    .x-form-group {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }
    .x-form-group .x-control-label {
        display: flex;
        font-size: 13px;
        margin-bottom: 0.125rem;
    }
    .x-form-group .x-control-input {
        display: flex;
        flex-direction: column;
    }
    .x-form-group .x-control-input .text-end .el-input__inner {
        text-align: right;
    }
    .x-form-group .x-form-control-feedback {
        font-size: 80%;
        color: #f20a34;
    }
    .x-form-group .x-control-input > div:first-child {
        width: 100%;
    }
    .x-form-group .x-control-input .el-input-group {
        display: flex;
    }
    .x-form-group .x-control-input .el-input-group .el-input-group__append{
        display: flex;
        width: auto;
        align-items: center;
    }
    .x-form-group .x-control-input .el-input-group .el-input-group__prepend {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script type="text/javascript">
    export default {
        props: {
            label: {
                default: null,
                type: String
            },
            error: {
                default: null
            },
        }
    }
</script>
