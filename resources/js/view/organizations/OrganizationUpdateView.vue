<template>
    <div class="view-content">
        <div class="ds-block bg-light">
            <el-form :model="organization">
                <el-row :gutter="20">
                    <el-col :md="6">
                        <el-form-item label="Name">
                            <el-input v-model="organization.name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :md="6">
                        <el-form-item label="Email">
                            <el-input v-model="organization.email"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :md="6">
                        <el-form-item label="Phone">
                            <el-input v-model="organization.phone"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :md="6">
                        <el-form-item label="Owner">
                            <el-input v-model="organization.owner" :disabled="true"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :md="6">
                        <el-form-item label="Address">
                            <el-input v-model="organization.address"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :md="24">
                        <el-form-item label="Description">
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="Please input"
                                v-model="organization.description">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <el-button class="btn btn-primary" type="primary" @click="update()">Update</el-button>
        </div>
    </div>
</template>
<script>
import OrganizationCartComponent from "../../components/organizations/OrganizationCartComponent.vue";

export default {
    name: "OrganizationUpdateView",
    components: {OrganizationCartComponent},
    data() {
        return {
            organizationId: this.$route.params.id,
        }
    },
    computed: {
        organization() {
            return this.$store.getters['organization/getOrganization'];
        },
    },
    mounted() {
        this.$store.dispatch('organization/readOrganization', this.organizationId);
    },
    methods: {
        update() {
            this.$store.dispatch('organization/updateOrganization', {organization: this.organization})
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.organization.name} successfully updated!`
                    });
                }).catch(() => {
            });
        }
    }
}
</script>
