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
        <b-row v-for="(data, index) in getData" :key="index">
          <b-col class="place-item" @click="onOpenAction(data.id)">
            <h5>{{data.name}} - {{data.position_name}}</h5>
            <div class="flex flex-row">
              <div class="flex-grow-2 flex flex-col">
                <span>
                  <b>Jumlah Kasbon :</b>
                </span>
                <span>{{data.amount}}</span>
                <span class="title-item">
                  <b>Potongan Setiap Bulan :</b>
                </span>
                <span>{{data.monthly_deduction}}</span>
                <span class="title-item">
                  <b>Keterangan :</b>
                </span>
                <span>{{data.note}}</span>
                <!-- <span class="title-item">Sudah Terbayarkan :</span>
                <span>Rp. 500.000</span>
                <span class="title-item">Belum Terbayarkan :</span>
                <span>Rp. 1.000.000</span>-->
              </div>
              <div class="flex-grow flex flex-col">
                <span>
                  <b>Status :</b>
                </span>
                <div class="badge-success" style="width:5rem">{{data.status_readable}}</div>
                <br />
                <span>
                  <b>Durasi :</b>
                </span>
                <span>{{data.duration}}</span>
              </div>
            </div>
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
    <Form />
  </div>
</template>

<script>
import Form from "./form";
import FilterData from "./filter";
export default {
  data() {
    return {
      title: "",
    };
  },
  components: { FilterData, Form },
  computed: {
    getData() {
      return this.$store.state.salaryAdvance.data;
    },
  },
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
.place-data::-webkit-scrollbar {
  display: none;
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
