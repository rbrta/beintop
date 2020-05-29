<template>
    <div role="document">
        <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <el-button class="close" size="mini" type="default" icon="el-icon-close" @click="$parent.$emit('close')" round circle></el-button>
        </div>
        <div class="modal-body" :class="{ 'no-padding' : noBodyPadding }">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModalSkeleton",
        props: {
            title: String,
            noBodyPadding: {
                type: Boolean,
                default: false
            }
        },
    }
</script>

<style scoped>

.modal-header {
    border-bottom: 1px solid #EBEEF5;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    font-weight: 600;
    font-size: 21px;
    margin: 0;
}

.modal-body {
    padding: 25px 30px 35px 30px;
}

</style>
