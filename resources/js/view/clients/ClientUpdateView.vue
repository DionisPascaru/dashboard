<template>
    <div class="view-content">
        <div class="ds-block bg-light view-title">
            <h1>Update client</h1>
        </div>

        <div class="ds-block bg-light">
            <el-form :model="client">
                <el-form-item label="Name">
                    <el-input v-model="client.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="client.email"></el-input>
                </el-form-item>
            </el-form>

            <el-button class="btn btn-primary" type="primary" @click="update()">Update</el-button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ClientUpdateView',
    computed: {
        client() {
            return this.$store.getters['client/getClient'];
        },
    },
    mounted() {
        this.$store.dispatch('client/readClient', this.$route.params.id);
    },
    methods: {
        update() {
            this.$store.dispatch('client/updateClient', { client: this.client })
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.client.name} successfully updated!`
                    });
                }).catch(() => {});
        }
    }
}
</script>

<style scoped lang="scss">

</style>
