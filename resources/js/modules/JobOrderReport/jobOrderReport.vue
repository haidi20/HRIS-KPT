<template>
  <div>
    <title>Laporan Job Order</title>
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
          <!-- semua data -->
          <b-tab title="Semua">
            <All />
          </b-tab>
          <!-- data yang statusnya tunda -->
          <!-- <b-tab title="Tunda">
            <All />
          </b-tab>-->
          <!-- data yang di lanjutkan lembur -->
          <b-tab title="Lembur">
            <All />
          </b-tab>
        </b-tabs>
      </div>
    </div>
  </div>
</template>

<script>
import All from "./all.vue";
export default {
  components: { All },
  data() {
    return {
      title: "Laporan Job Order",
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
