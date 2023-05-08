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
        <b-row v-for="(item, index) in getData" :key="index">
          <b-col class="place-item">
            <b-row>
              <b-col :cols="getIsMobile ? '12' : '10'" @click="onOpenAction(item.id)">
                <h5>
                  <b>{{item.position_name}}</b>
                </h5>
                <h6>
                  <b>{{item.employee_name}}</b>
                </h6>
                <div>
                  <span>Waktu :</span>
                  <br />
                  <span>{{item.duration_readable}}</span>
                  <br />
                  <span>{{item.date_start}} - {{item.date_end}}</span>
                </div>
                <div style="margin-top: 10px">
                  <span>Pengawas :</span>
                  <br />
                  <span>{{item.created_by_name}}</span>
                </div>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet">
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
import { isMobile } from "../../utils";
import Form from "./form";
import FilterData from "./filter.vue";
export default {
  data() {
    return {
      title: "",
    };
  },
  components: { FilterData, Form },
  computed: {
    getData() {
      return this.$store.state.vacation.data;
    },
    getIsMobile() {
      return isMobile();
    },
  },
  methods: {
    onOpenAction(id) {
      //   console.info(id);
      this.$refs.myBottomSheet.open();
    },
    onCreate() {
      this.$bvModal.show("vacation_form");
    },
    onFilter() {
      this.$bvModal.show("vacation_filter");
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
