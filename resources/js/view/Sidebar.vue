<template>
    <div class="ds-sidebar">
        <div>
            <div class="ds-logo">
                LOGO
            </div>
            <el-menu
                :default-active="activeIndex"
                class="ds-sidebar-menu"
                :router="true">
                <el-menu-item class="ds-sidebar-menu--item" index="ExampleComponent"
                              :route="{ name: 'ExampleComponent' }">
                    <i class="el-icon-eleme"></i>
                    <span>Example</span>
                </el-menu-item>
                <el-menu-item class="ds-sidebar-menu--item" index="Users" :route="{ name: 'Users' }">
                    <i class="el-icon-user"></i>
                    <span>Users</span>
                </el-menu-item>
                <el-menu-item class="ds-sidebar-menu--item" index="Projects" :route="{ name: 'Projects' }">
                    <i class="el-icon-s-grid"></i>
                    <span>Projects</span>
                </el-menu-item>
            </el-menu>
        </div>
        <div>
            <router-link class="ds-auth-user-link" :to="{ name: 'ProfileView'}">
                <div class="ds-auth-user">
                    <div class="ds-auth-user--avatar">
                        <div class="ds-auth-user--no-image">
                            <i class="el-icon-user"></i>
                        </div>
                    </div>
                    <div class="ds-auth-user--info">
                        <span class="ds-auth-user--name">{{ authUser.name }}</span>
                        <span class="ds-auth-user--email">{{ authUser.email }}</span>
                    </div>
                </div>
            </router-link>
            <button class="ds-logout--btn" @click="logout">
                Logout
            </button>
        </div>
    </div>
</template>
<script>
import logo from '@/assets/logo.svg';

export default {
    name: "Sidebar",
    computed: {
        activeIndex() {
            return this.$route.name;
        },
        getLogo() {
            return logo;
        },
        authUser() {
            return this.$store.getters['auth/loadUser'];
        }
    },
    mounted() {
        this.$store.dispatch('auth/authUser');
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push({name: 'Home'});
            })
        },
    }
};
</script>
