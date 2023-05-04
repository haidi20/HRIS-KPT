<template>
  <div>
    <title>Absensi</title>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <b-row>
          <b-col class="place-title">
            <h2>{{ title }}</h2>
            <p class="version">{{ version }}</p>
          </b-col>
        </b-row>
        <br />
        <b-tabs content-class="mt-3" active>
          <b-tab title="Main">
            <Main />
          </b-tab>
        </b-tabs>
      </div>
    </div>
  </div>
</template>

<script>
import Main from "./main.vue";
export default {
  components: { Main },
  data() {
    return {
      title: "Absensi",
      version: "v1.1",
    };
  },
};
</script>

<style lang="css" scoped>
.version {
  font-size: 13px;
  margin-left: 5px;
}
.place-title {
  display: -webkit-inline-box;
}
</style>
