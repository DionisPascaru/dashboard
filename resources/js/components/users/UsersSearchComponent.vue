<template>
    <div class="search-form">
        <h4>Filters</h4>
        <el-form :model="options.filters">
            <el-row :gutter="20">
                <el-col :md="6">
                    <el-form-item label="Name:" prop="name">
                        <el-input v-model="options.filters.name"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :md="6">
                    <el-form-item label="Role:" prop="role_id">
                        <el-select style="width: 100%" v-model="options.filters.role_id" placeholder="Select">
                            <el-option
                                v-for="item in this.roles"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :md="6">
                    <el-form-item label="Date from:" prop="date_from">
                        <el-date-picker
                            style="width: 100%"
                            v-model="options.filters.date_from"
                            type="date"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :md="6">
                    <el-form-item label="Date till:" prop="date_till">
                        <el-date-picker
                            style="width: 100%"
                            v-model="options.filters.date_till"
                            type="date"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <div style="display: flex; justify-content: flex-end;">
            <el-button class="btn btn-default" @click="reset">
                Reset
            </el-button>
            <el-button class="btn btn-primary" type="primary" @click="search">
                Search
            </el-button>
        </div>
    </div>
</template>

<script>
export default {
    name: "UsersSearchComponent",
    props: ['options'],
    computed: {
      roles() {
          return this.$store.getters['user/getRoles'];
      }
    },
    mounted() {
        this.$store.dispatch('user/getRoles');
    },
    methods: {
        search() {
            this.$emit('search-filters', this.options);
        },
        reset() {
            this.options.filters.name = '';
            this.options.filters.role_id = null;
            this.options.filters.date_from = null;
            this.options.filters.date_till = null;
            this.options.pageNum = 1;
            this.options.pageSize = 10;
            this.$emit('search-filters', this.options);
        }
    }

}
</script>
