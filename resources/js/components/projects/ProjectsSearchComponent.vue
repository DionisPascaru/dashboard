<template>
    <div>
        <h4>Filters</h4>
        <el-form :model="options.filters">
            <el-row :gutter="20">
                <el-col :md="12">
                    <el-form-item label="Title" prop="title">
                        <el-input v-model="options.filters.title"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :md="12">
                    <el-form-item label="Category" prop="category_id">
                        <el-select v-model="options.filters.category_id" placeholder="Select">
                            <el-option
                                v-for="item in this.projectCategories"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <div style="display: flex; justify-content: flex-end;">
            <el-button type="info" @click="reset">
                Reset
            </el-button>
            <el-button type="primary" @click="search">
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
            this.options.pageNum = 1;
            this.options.pageSize = 10;
            this.$emit('search-filters', this.options);
        }
    }
}
</script>
