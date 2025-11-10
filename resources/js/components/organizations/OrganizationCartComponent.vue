<template>
    <el-card shadow="hover">
        <div class="ds-card-heading">
            <span>{{organization.name}}</span>
            <p>{{truncate(organization.description, 150)}}</p>
        </div>
        <div class="ds-card-contacts">
            <ul>
                <li><i class="el-icon-user"></i>{{organization.owner}}</li>
                <li><i class="el-icon-phone-outline"></i>{{organization.phone}}</li>
                <li><i class="el-icon-message"></i>{{organization.email}}</li>
                <li><i class="el-icon-location-outline"></i>{{truncate(organization.address, 40)}}</li>
            </ul>
        </div>
    </el-card>
</template>
<script>
export default {
    name: 'OrganizationCartComponent',
    props: ['organization'],
    methods: {
        truncate(text, length) {
            if (!text) return '';
            return text.length > length ? text.substring(0, length) + '…' : text;
        }
    }
}

</script>
<style scoped lang="scss">
.ds-card-contacts {
    ul {
        list-style-type: none;
        padding: unset;

        li {
            i {
                margin-right: 10px;
            }
        }
    }
}
</style>
