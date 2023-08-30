<template>
    <div>
        <el-upload
            action="#"
            ref="uploadImages"
            list-type="picture-card"
            :file-list.sync="this.fileList"
            :multiple="true"
            :auto-upload="false"
            :on-change="handleUpload"
            :on-remove="onRemoved">
            <i class="el-icon-plus"></i>
        </el-upload>
    </div>
</template>

<script>
export default {
    name: 'MultipleFilesUploadComponent',
    props: ['files'],
    computed: {
      fileList() {
          return this.files;
      }
    },
    methods: {
        uploadEvent(file) {
            this.$emit('upload-callback', file);
        },
        removeEvent(file) {
            this.$emit('remove-callback', file);
        },
        handleUpload(file) {
            this.uploadEvent(file);
        },
        onRemoved(file) {
            this.removeEvent(file);
        },
    }
}
</script>
