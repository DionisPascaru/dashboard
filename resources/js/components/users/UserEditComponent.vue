<template>
    <div>
        <el-button type="primary" @click="loadUser(userId)" icon="el-icon-edit"></el-button>

        <el-dialog title="Edit user" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="user">
                <el-form-item label="Name">
                    <el-input v-model="user.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="user.email"></el-input>
                </el-form-item>
                <el-form-item label="Role">
                    <el-select v-model="user.role" placeholder="Select">
                        <el-option
                            v-for="item in this.roles"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button type="primary" @click="">Update</el-button>
              </span>
        </el-dialog>
    </div>
</template>

<script>
import roles from '../../enums/user-roles.enum';

export default {
    name: 'UserEditComponent',
    props: {
        userId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            dialogFormVisible: false,
            roles: roles
        }
    },
    computed: {
      user() {
          return this.$store.getters['user/getUser'];
      }
    },
    methods: {
        loadUser(id) {
            this.dialogFormVisible = true;

            this.$store.dispatch('user/loadUser', id);
        },
    }
}
</script>
