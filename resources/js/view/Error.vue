<template>
  <div class="error">
    <div class="header">
      <span>WOW Dashboard</span>
    </div>

    <el-card>
      <h1 class="code">{{ code }}</h1>
      <h2 class="message">{{ errorMessage }}</h2>

      <router-link to="/" tag="button">
        <span>Back to home</span>
      </router-link>
    </el-card>
  </div>
</template>

<script>
export default {
  name: "Error",
  data() {
    return {
      errors: {
        404: "Page not found",
        403: `Forbidden! You don't have permission to access this page`,
        500: "Internal server error",
      },
    };
  },
  props: {
    code: {
      type: Number,
      default: 404,
    },
  },
  computed: {
    errorMessage: function () {
      return this.errors[this.code];
    },
  },
};
</script>
