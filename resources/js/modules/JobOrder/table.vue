<template>
  <div>
    <b-row style="margin-top: 10px">
      <b-col cols>
        <b-button variant="info" size="sm" class @click="onFilter()">Filter</b-button>
      </b-col>
      <b-col cols style="align-item: right">
        <b-button variant="success" size="sm" class="float-end" @click="onDetail()">Tambah</b-button>
      </b-col>
    </b-row>
    <br />
    <b-row>
      <b-col class="place-data">
        <b-row v-for="(item, index) in getData" :key="index">
          <b-col class="place-item">
            <b-row>
              <b-col :cols="getIsMobile ? '12' : '10'" @click="onOpenAction(item.id)">
                <h6>
                  <b>{{item.project_name}}</b>
                </h6>
                <span>catatan:</span>
                <br />
                <span>{{onLimitSentence(item.project_note)}}</span>
                <b-row class="place-content">
                  <b-col cols="7">
                    <span>
                      Status :
                      <div :class="`badge-${item.status_color}`">{{item.status}}</div>
                    </span>
                    <br />
                    <span>Total Karyawan : {{item.employee_total}}</span>
                    <br />
                    <span>Total Karyawan Aktif: {{item.employee_active_total}}</span>
                  </b-col>
                  <b-col cols="5">
                    <span>Penilaian :</span>
                    <span>{{item.count_assessment}}/2</span>
                    <br />
                    <div>
                      <b-form-checkbox
                        class="display-inline"
                        v-model="item.is_assessment_quality_control"
                        disabled
                      ></b-form-checkbox>
                      <span>QC</span>
                    </div>
                    <div>
                      <b-form-checkbox
                        class="display-inline"
                        v-model="item.is_assessment_foreman"
                        disabled
                      ></b-form-checkbox>
                      <span>Pengawas</span>
                    </div>
                  </b-col>
                </b-row>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet">
          <div class="flex flex-col">
            <div class="action-item">tunda</div>
            <div class="action-item">mulai kembali</div>
            <div class="action-item">selesai</div>
            <div class="action-item">lembur</div>
            <div class="action-item">selesai lembur</div>
            <div class="action-item">perbaikan</div>
            <div class="action-item">ubah</div>
            <div class="action-item" @click="onDetail">detail</div>
            <div class="action-item">penilaian</div>
          </div>
        </vue-bottom-sheet>
      </b-col>
    </b-row>
    <FilterData />
  </div>
</template>

<script>
import { isMobile } from "../../utils";
import FilterData from "./filter.vue";
export default {
  data() {
    return {
      title: "",
      getDataBaseClick: null,
    };
  },
  components: { FilterData },
  computed: {
    getData() {
      return this.$store.state.jobOrder.data;
    },
    getIsMobile() {
      return isMobile();
    },
  },
  methods: {
    onOpenAction(id) {
      //   console.info(id);
      this.getDataBaseClick = id;
      this.$refs.myBottomSheet.open();
    },
    onDetail() {
      console.info(this.getDataBaseClick);
      this.$refs.myBottomSheet.close();
      this.$bvModal.show("job_order_form");
    },
    onFilter() {
      this.$bvModal.show("job_order_filter");
    },
    onLimitSentence(sentence) {
      const maxLength = 35;

      if (sentence.length > maxLength) {
        sentence = sentence.substring(0, maxLength) + "...";
      }

      return sentence;
    },
  },
};
</script>

<style lang="scss" scoped>
.place-data {
  max-height: 500px;
  //max-height: 20%;
  overflow-y: scroll;
}
.place-data::-webkit-scrollbar {
  display: none;
}
.place-item {
  border-bottom: 1px solid #dbdfea;
  padding: 0.5rem;
}
.place-content {
  font-size: 15px;
  margin-top: 10px;
}
.action-item {
  padding: 25px 0px 25px 20px;
  border-bottom: 1px solid #dbdfea;
}
.badge-success {
  padding: 0.115rem 0.5rem;
}
</style>
