<template>
    <div>
        <el-card class="auth-form">
            <h1>Register</h1>
            <el-form
                :model="register"
                status-icon
                :rules="rules"
                ref="ruleForm"
                label-position="top"
                class="form-group">
                <div class="ds-flex flex-gap">
                    <el-form-item label="Name" prop="name" class="form-input">
                        <el-input type="name" v-model="register.name" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Email" prop="email" class="form-input">
                        <el-input type="email" v-model="register.email" autocomplete="off"></el-input>
                    </el-form-item>
                </div>
                <div class="ds-flex flex-gap">
                    <el-form-item label="Password" prop="password" class="form-input">
                        <el-input type="password" v-model="register.password" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Confirm password" prop="confirmPassword" class="form-input">
                        <el-input type="password" v-model="register.confirmPassword" autocomplete="off"></el-input>
                    </el-form-item>
                </div>
                <div class="auth-form-redirect">
                    <router-link :to="{ name: 'Login'}">Login?</router-link>
                </div>
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item>
                            <el-button type="primary" @click="submitForm('ruleForm')">Submit</el-button>
                            <el-button @click="resetForm('ruleForm')">Reset</el-button>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
        </el-card>
    </div>
</template>
<script>
export default {
    name: 'Register',
    data() {
        return {
            register: {
                name: '',
                email: '',
                password: '',
                confirmPassword: '',
            },
            rules: {
                name: [
                    {
                        required: true,
                        message: "Name is required",
                        trigger: ["blur", "change"],
                    },
                ],
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
                confirmPassword: [
                    {
                        validator: (rule, value, callback) => {
                            if (value === '') {
                                callback(new Error('Confirm password is required'));
                            } else if (value !== this.register.password) {
                                callback(new Error('Confirm password don\'t match!'));
                            } else {
                                callback();
                            }
                        }
                    },
                ]

            },
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$store.dispatch('auth/register', this.register)
                        .then(() => {
                            this.$router.push({name: 'Users'})
                            this.$notify({
                                title: 'Success',
                                type: 'success',
                                message: `Register account successfully!`
                            });
                        })
                        .catch((error) => {
                            // this.$notify({
                            //     title: 'Error',
                            //     type: 'error',
                            //     message: error
                            // })
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
    max-width: 500px;
}
</style>
