<template>
    <div class="view-content">
        <div class="ds-block bg-light">
            <el-row :gutter="20">
                <el-col :md="12">
                    <el-form :model="client">
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item label="Name">
                                    <el-input v-model="client.name"></el-input>
                                </el-form-item>
                                <el-form-item label="Email">
                                    <el-input v-model="client.email"></el-input>
                                </el-form-item>
                                <el-form-item label="Created">
                                    <el-input v-model="client.created_at" :disabled="true"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item label="Phone">
                                    <el-input v-model="client.phone"></el-input>
                                </el-form-item>
                                <el-form-item label="Status">
                                    <div class="ds-status"
                                         v-if="client.status"
                                         :class="`ds-status-${client.status.value}`">
                                        {{ client.status.name }}
                                    </div>
                                </el-form-item>
                                <el-form-item label="Updated">
                                    <el-input v-model="client.updated_at" :disabled="true"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </el-col>
                <el-col :md="12"></el-col>
            </el-row>
            <el-button class="btn btn-primary" type="primary" @click="update()">Update</el-button>
        </div>

        <div class="ds-block bg-light">
            <el-row :gutter="20">
                <el-col :md="24">
                    <organization-create-modal-component></organization-create-modal-component>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :md="8" v-for="organization in organizations" :key="organization.id">
                    <organization-cart-component :organization="organization"></organization-cart-component>
                </el-col>
                <el-col v-if="!organizations.length">
                    <span>No organizations</span>
                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
import OrganizationCartComponent from "../../components/organizations/OrganizationCartComponent.vue";
import OrganizationCreateModalComponent from "../../components/organizations/OrganizationCreateModalComponent.vue";

export default {
    name: 'ClientUpdateView',
    components: {OrganizationCreateModalComponent, OrganizationCartComponent},
    data() {
      return {
          clientId: this.$route.params.id,
      }
    },
    computed: {
        client() {
            return this.$store.getters['client/getClient'];
        },
        organizations() {
            return this.$store.getters['client/getOrganizations'];
        }
    },
    mounted() {
        this.$store.dispatch('client/readClient', this.clientId);
        this.$store.dispatch('client/readOwnedOrganizations', this.clientId);
    },
    methods: {
        update() {
            this.$store.dispatch('client/updateClient', {client: this.client})
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
