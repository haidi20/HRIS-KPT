<template>
  <div>
    <DatatableClientSide
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="roster"
      nameLoading="table"
      :filter="true"
      bordered
    >
      <template v-slot:filter>
        <b-col cols>
          <b-form-group label="Bulan" label-for="date" class="place_filter_table">
            <DatePicker
              id="date"
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
            @click="onExport()"
            :disabled="is_loading_export"
          >
            <i class="fas fa-file-excel"></i>
            Export
          </b-button>
          <span v-if="is_loading_export">Loading...</span>
        </b-col>
      </template>
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <template v-for="(column, index) in columns">
            <b-td :key="`col-${index}`">{{ item[column.field] }}</b-td>
          </template>
        </b-tr>
      </template>
    </DatatableClientSide>
  </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import DatatableClientSide from "../../components/DatatableClient";

export default {
  data() {
    return {
      is_loading_export: false,
      options: {
        perPage: 20,
        // perPageValues: [5, 10, 25, 50, 100],
        filterByColumn: true,
        texts: {
          filter: "",
          count: " ",
        },
      },
      columns: [
        {
          label: "",
          field: "action",
          width: "40px",
          class: "",
        },
        {
          label: "Nama Karyawan",
          field: "employee_name",
          width: "40px",
          class: "",
        },
        {
          label: "Jabatan",
          field: "position_name",
          width: "40px",
          class: "",
        },
        {
          label: "Jenis Pekerjaan",
          field: "job_name",
          width: "40px",
          class: "",
        },
        {
          label: "Waktu Mulai",
          field: "date_time_start",
          width: "40px",
          class: "",
        },
        {
          label: "Waktu Selesai",
          field: "date_time_end",
          width: "40px",
          class: "",
        },
        {
          label: "Durasi",
          field: "duration",
          width: "40px",
          class: "",
        },
        {
          label: "Catatan",
          field: "note",
          width: "40px",
          class: "",
        },
      ],
    };
  },
  components: {
    DatePicker,
    DatatableClientSide,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.jobOrder.data;
    },
    params() {
      return this.$store.state.jobOrder.params;
    },
  },
  methods: {
    onExport() {
      //
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
</style>
