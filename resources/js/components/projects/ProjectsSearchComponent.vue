<template>
    <div class="search-form">
        <h4>Filters</h4>
        <el-form :model="options.filters">
            <el-row :gutter="20">
                <el-col :md="6">
                    <el-form-item label="Title:" prop="title">
                        <el-input v-model="options.filters.title"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :md="6">
                    <el-form-item label="Category:" prop="category_id">
                        <el-select style="width: 100%" v-model="options.filters.category_id" placeholder="Select">
                            <el-option
                                v-for="item in this.projectCategories"
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
    name: 'ProjectsSearchComponent',
    props: ['options'],
    computed: {
        projectCategories() {
            return this.$store.getters['projectCategories/getProjectCategories'];
        }
    },
    mounted() {
        this.$store.dispatch('projectCategories/loadProjectCategories');
    },
    methods: {
        search() {
            this.$emit('search-filters', this.options);
        },
        reset() {
            this.options.filters.title = '';
            this.options.filters.category_id = null;
            this.options.filters.date_from = null;
            this.options.filters.date_till = null;
            this.options.pageNum = 1;
            this.options.pageSize = 10;
            this.$emit('search-filters', this.options);
        }
    }
}
</script>
