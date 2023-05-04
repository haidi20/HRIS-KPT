<template>
  <div>
    <b-row style="margin-top: 10px">
      <b-col cols>
        <b-button variant="info" size="sm" class @click="onFilter()">Filter</b-button>
      </b-col>
      <b-col cols style="align-item: right">
        <b-button variant="success" size="sm" class="float-end" @click="onCreate()">Tambah</b-button>
      </b-col>
    </b-row>
    <br />
    <b-row>
      <b-col class="place-data">
        <b-row v-for="i in 3" :key="i">
          <b-col class="place-item" @click="onOpenAction(i)">
            <h5>Perbaikan Kapal Bagian Belakang</h5>
            <span>Total Karyawan : 5</span>
            <br />
            <span>Total Karyawan Aktif: 4</span>
            <!--  -->
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet">
          <b-row class="place-action">
            <b-col class="flex flex-col">
              <div class="action-item">tunda</div>
              <div class="action-item">mulai</div>
              <div class="action-item">selesai</div>
              <div class="action-item">perbaikan</div>
              <div class="action-item">ubah</div>
              <div class="action-item">penilaian</div>
            </b-col>
          </b-row>
        </vue-bottom-sheet>
      </b-col>
    </b-row>
    <FilterData />
  </div>
</template>

<script>
import FilterData from "./filter.vue";
export default {
  data() {
    return {
      title: "",
    };
  },
  components: { FilterData },
  methods: {
    onOpenAction(i) {
      //   console.info(i);
      this.$refs.myBottomSheet.open();
    },
    onCreate() {
      //   console.info("create");
      this.$bvModal.show("job_order_form");
    },
    onFilter() {
      this.$bvModal.show("job_order_filter");
    },
  },
};
</script>

<style lang="scss" scoped>
.place-data {
  max-height: 500px;
  overflow-y: scroll;
}
.place-item {
  border-bottom: 1px solid #dbdfea;
  padding: 0.5rem;
}
.place-action {
  padding: 10px;
}
.action-item {
  margin: 10px 0px 10px 0px;
  padding-left: 10px;
}
</style>
