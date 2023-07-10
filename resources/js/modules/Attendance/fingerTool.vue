<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="attendance"
      nameLoading="finger"
      :filter="true"
      bordered
    >
      <template v-slot:filter>
        <b-col cols style="margin-bottom: 15px">
          <b-form-group label="Bulan" label-for="month" class="place_filter_table">
            <DatePicker
              id="month"
              v-model="params.month"
              format="YYYY-MM"
              type="month"
              placeholder="pilih bulan"
            />
          </b-form-group>
          <b-button
            class="place_filter_table"
            variant="success"
            size="sm"
            @click="onFilter()"
            :disabled="getIsLoadingData"
          >Kirim</b-button>
          <span v-if="getIsLoadingData">Loading...</span>
        </b-col>
      </template>
      <template v-slot:thead>
        <b-th
          v-for="(item, index) in getFingerTools"
          v-bind:key="`thead-${index}`"
          style="width: 30px"
        >{{ item.name }}</b-th>
      </template>
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td nowrap>{{ item.date_readable }}</b-td>
          <b-td v-for="(finger, key) in getFingerTools" :key="key">{{ item[finger.id] }}</b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
import moment from "moment";
import VueSelect from "vue-select";
import DatePicker from "vue2-datepicker";
import DatatableClient from "../../components/DatatableClient";

export default {
  data() {
    return {
      is_loading_export: false,
      options: {
        perPage: 10,
        // perPageValues: [5, 10, 25, 50, 100],
        filterByColumn: true,
        texts: {
          filter: "",
          count: " ",
        },
      },
      columns: [
        {
          label: "Tanggal",
          field: "date_readable",
          width: "100px",
          rowspan: 2,
          class: "",
        },
      ],
    };
  },
  components: {
    DatePicker,
    DatatableClient,
    VueSelect,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.attendance.data.finger;
    },
    getFingerTools() {
      return this.$store.state.master.data.finger_tools;
    },
    getIsLoadingData() {
      return this.$store.state.attendance.loading.finger;
    },
    params() {
      return this.$store.state.attendance.params.finger;
    },
  },
  methods: {
    onFilter() {
      this.$store.dispatch("attendance/fetchDataBaseFinger");
    },
    setLabelDate(date) {
      return moment(date).format("DD");
    },
    setLabelNameDate(date) {
      return moment(date).format("dddd");
    },
  },
};
</script>

<style lang="css">
.VueTables__search-field {
  display: none;
}

.place_filter_table {
  align-items: self-end;
  margin-bottom: 0;
  display: inline-block;
}

.table-wrapper {
  overflow-x: auto;
}
.item-hour {
  height: 18px;
}
.hour-reguler {
  color: green;
}
.hour-rest {
  color: blue;
}
</style>
