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
            <h5>Muhammad Adi - Welder</h5>
            <div class="flex flex-row">
              <div class="flex-grow-2 flex flex-col">
                <span>Jumlah Kasbon :</span>
                <span>Rp. 1.500.000</span>
                <span class="title-item">Potongan Setiap Bulan :</span>
                <span>Rp. 500.000</span>
                <span class="title-item">Sudah Terbayarkan :</span>
                <span>Rp. 500.000</span>
                <span class="title-item">Belum Terbayarkan :</span>
                <span>Rp. 1.000.000</span>
              </div>
              <div class="flex-grow flex flex-col">
                <span>Durasi :</span>
                <span>3 Bulan</span>
              </div>
            </div>
            <!-- <b-row>
              <b-col col sm="10">
                <span>Jumlah Kasbon :</span>
                <br />
                <span>Rp. 1.500.000</span>
                <br />
                <span>Potongan Setiap Bulan :</span>
                <br />
                <span>Rp. 500.000</span>
                <br />
                <span>Sudah Terbayarkan :</span>
                <br />
                <span>Rp. 500.000</span>
                <br />
                <span>Belum Terbayarkan :</span>
                <br />
                <span>Rp. 1.000.000</span>
              </b-col>
              <b-col col sm="1">
                <span>Durasi :</span>
                <br />
                <span>3 Bulan</span>
              </b-col>
            </b-row>-->
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet" max-height="20%">
          <div class="flex flex-col">
            <div class="action-item">ubah</div>
          </div>
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
      this.$refs.myBottomSheet.close();
      this.$bvModal.show("salary_advance_form");
    },
    onFilter() {
      this.$bvModal.show("salary_advance_filter");
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
.action-item {
  padding: 25px 0px 25px 20px;
  // border-bottom: 1px solid #dbdfea;
}
.title-item {
  margin-top: 10px;
}
</style>
