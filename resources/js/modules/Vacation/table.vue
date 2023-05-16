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
        <template v-if="getLoadingTable">
          <b-tr>
            <b-td>Loading...</b-td>
          </b-tr>
        </template>
        <template v-else-if="getData.length > 0">
          <b-row v-for="(item, index) in getData" :key="index">
            <b-col class="place-item">
              <b-row>
                <b-col :cols="getIsMobile ? '12' : '10'" @click="onOpenAction(item)">
                  <h5>
                    <b>{{item.position_name}}</b>
                  </h5>
                  <h6>
                    <b>{{item.employee_name}}</b>
                  </h6>
                  <b-row>
                    <b-col cols>
                      <span>Waktu :</span>
                    </b-col>
                    <b-col cols>
                      <span>Tanggal :</span>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col cols>
                      <span>{{item.duration_readable}}</span>
                    </b-col>
                    <b-col cols>
                      <span>{{item.date_start_readable}}</span>
                      <br />
                      <span>{{item.date_end_readable}}</span>
                    </b-col>
                  </b-row>
                  <div>
                    <span>Pengawas :</span>
                    <br />
                    <span>{{item.creator_name}}</span>
                  </div>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </template>

        <template v-else>
          <b-tr>
            <b-td>Data Kosong</b-td>
          </b-tr>
        </template>
        <vue-bottom-sheet ref="myBottomSheet" max-height="30%">
          <div class="flex flex-col mb-4">
            <!-- <div class="action-item">{{getConditionEdit()}}</div> -->
            <div class="action-item" @click="onAction('edit', 'Ubah')">
              <span v-if="getConditionEdit()">Ubah</span>
            </div>
            <div class="action-item" @click="onDelete()">
              <span v-if="getConditionEdit()">Ubah</span>
            </div>
          </div>
        </vue-bottom-sheet>
      </b-col>
    </b-row>
    <FilterData />
    <Form />
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
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
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.vacation.data;
    },
    getLoadingTable() {
      return this.$store.state.vacation.loading.table;
    },
    getIsMobile() {
      return isMobile();
    },
    form() {
      return this.$store.state.vacation.form;
    },
  },
  methods: {
    onOpenAction(data) {
      this.$store.commit("vacation/CLEAR_FORM");
      this.$store.commit("vacation/INSERT_FORM", {
        form: data,
      });
      this.$refs.myBottomSheet.open();
    },
    onCreate() {
      this.$store.commit("vacation/CLEAR_FORM");
      this.$bvModal.show("vacation_form");
    },
    onFilter() {
      this.$bvModal.show("vacation_filter");
    },
    onAction(type, title) {
      //   console.info(type, title);

      if (this.getConditionEdit()) {
        this.$refs.myBottomSheet.close();
        this.$bvModal.show("vacation_form");
      }
    },
    onLimitSentence(sentence) {
      const maxLength = 35;

      if (sentence.length > maxLength) {
        sentence = sentence.substring(0, maxLength) + "...";
      }

      return sentence;
    },
    getConditionEdit() {
      //   console.info(Number(this.form.created_by), Number(this.getUserId));
      return Number(this.form.created_by) == Number(this.getUserId);
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
