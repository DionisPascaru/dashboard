<template>
    <div>
        <el-card class="auth-form">
            <h1>Login</h1>
            <el-form
                :model="login"
                status-icon
                :rules="rules"
                ref="ruleForm"
                label-position="top"
                class="form-group">
                <el-form-item label="Email" prop="email" class="form-input">
                    <el-input type="email" v-model="login.email" autocomplete="email"></el-input>
                </el-form-item>
                <el-form-item label="Password" prop="password" class="form-input">
                    <el-input type="password" v-model="login.password" autocomplete="password"></el-input>
                </el-form-item>
                <div class="auth-form-redirect">
                    <router-link :to="{ name: 'Register'}">Register?</router-link>
                </div>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm')">Submit</el-button>
                    <el-button @click="resetForm('ruleForm')">Reset</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data(){
        return {
            login: {
                email: '',
                password: ''
            },
            rules: {
                email: [
                    {
                        required: true,
                        message: "Email is required",
                        trigger: ["blur", "change"],
                    },
                    {
                        type: "email",
                        message: "Email should have a valid format",
                        trigger: ["blur", "change"],
                    },
                ],
                password: [
                    {
                        required: true,
                        message: "Password is required",
                        trigger: ["blur", "change"],
                    },
                ],
            },
        }
    },
    methods: {
        submitForm(formName){
            this.$refs[formName].validate((valid) => {
                if (valid){
                    this.$store.dispatch('auth/login', this.login)
                        .then(()=>{
                            this.$router.push({name: 'Users'})
                            this.$notify({
                                title: 'Success',
                                type: 'success',
                                message: `Log in successfully!`
                            });
                        })
                        .catch(e => {
                            this.$notify.error({
                                title: 'Error',
                                message: e
                            });
                        })
                } else {
                    return false;
                }
            })
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    }
}
</script>

<style scoped lang="scss">
.auth-form {
    max-width: 300px;
}
</style>
