<template>
    <div>
        <el-card class="auth-form">
            <h1>Login</h1>
            <el-form :model="login" status-icon :rules="rules" ref="ruleForm" label-position="top">
                <el-form-item label="Email" prop="email">
                    <el-input type="email" v-model="login.email" autocomplete="on"></el-input>
                </el-form-item>
                <el-form-item label="Password" prop="password">
                    <el-input type="password" v-model="login.password" autocomplete="on"></el-input>
                </el-form-item>
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
                email: null,
                password: null
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
                            this.$router.push({name: 'ExampleComponent'})
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
    margin: 60px auto;
}
</style>
