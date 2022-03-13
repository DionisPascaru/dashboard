<template>
    <el-descriptions label="Username">
        <el-descriptions-item label="Username">{{ user.name }}</el-descriptions-item>
        <el-descriptions-item label="Email">{{ user.email }}</el-descriptions-item>
        <el-descriptions-item label="Role">{{ user.role }}</el-descriptions-item>
    </el-descriptions>
</template>

<script>
export default {
    name: 'UserDetails',
    computed: {
      user(){
          return this.$store.getters['user/getUser'];
      }
    },
    mounted() {
        this.loadUser();
    },
    methods: {
        loadUser(){
            this.$store.dispatch('user/loadUser', this.$route.params.id);
        }
    }
}
</script>
