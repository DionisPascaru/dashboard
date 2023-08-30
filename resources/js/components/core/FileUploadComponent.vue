<template>
    <div>
        <el-upload
            action="#"
            ref="upload"
            list-type="picture-card"
            :limit="1"
            :auto-upload="false"
            :on-change="handleUpload"
            :on-remove="onRemoved"
            :file-list="this.fileList">
            <i class="el-icon-plus"></i>
        </el-upload>
    </div>
</template>

<script>
export default {
    name: 'FileUploadComponent',
    props: ['file'],
    computed: {
        fileList() {
            return this.file ? [this.file] : [];
        }
    },
    methods: {
        uploadEvent() {
            this.$emit('upload-callback', this.fileList[0]);
        },
        handleUpload(file) {
            this.fileList[0] = file;

            this.uploadEvent();
        },
        onRemoved() {
            this.fileList.slice(0, 1);

            this.uploadEvent();
        },
    }
}
</script>
