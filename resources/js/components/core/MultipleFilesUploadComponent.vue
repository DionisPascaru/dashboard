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
        uploadEvent() {
            this.$emit('upload-callback', this.fileList);
        },
        handleUpload(file) {
            this.fileList.push(file);

            this.uploadEvent();
        },
        onRemoved(file) {
            const index = this.fileList.findIndex(item => item.uid === file.uid);

            if (index !== -1) {
                this.fileList.splice(index, 1);
            }

            this.uploadEvent();
        },
    }
}
</script>
