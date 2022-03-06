<template>
    <div>
        <div class="view-title">
            <h1>Users</h1>
        </div>
        <div class="view-content">
            <el-table
                :data="tableData"
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="Name"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="Email">
                </el-table-column>
                <el-table-column
                    prop="phone"
                    label="Phone"
                    width="180">
                </el-table-column>
            </el-table>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Users',
    data(){
        return {
            tableData: [
                {
                    id: 1,
                    name: 'Jhon Smith',
                    email: 'john@gmail.com',
                    phone: '078787878'
                },
                {
                    id: 2,
                    name: 'David Backhem',
                    email: 'david@gmail.com',
                    phone: '0555551115'
                },
                {
                    id: 3,
                    name: 'Andrew Ryal',
                    email: 'andrew@gmail.com',
                    phone: '0989898888'
                }
            ]
        }
    }
}
</script>
