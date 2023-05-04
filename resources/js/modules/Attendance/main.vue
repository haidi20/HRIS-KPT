<template>
  <div>
    <DatatableClientSide
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="attendance"
      nameLoading="table"
      :filter="true"
      bordered
    >
      <template v-slot:filter>
        <b-col cols>
          <b-form-group label="Bulan" label-for="date" class="place_filter_table">
            <DatePicker
              id="date"
              v-model="params.date"
              format="YYYY-MM"
              type="month"
              placeholder="pilih bulan"
              @input="onChangeDateFilter"
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
      <!-- <template v-slot:thead>
        <b-th v-for="i in 30" :key="`thead-${i}`" style="width: 30px">{{onCustomLabelNameDate(i)}}</b-th>
      </template>-->
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
          label: "No.",
          field: "no",
          width: "10px",
          rowspan: 2,
          class: "",
        },
        {
          label: "Nama Karyawan",
          field: "employee_name",
          width: "40px",
          rowspan: 2,
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
    getData() {
      return this.$store.state.attendance.data;
    },
    params() {
      return this.$store.state.attendance.params;
    },
  },
  methods: {
    onChangeDateFilter() {
      //
    },
    onCustomLabelDate(date) {
      return moment(date).format("DD");
    },
    onCustomLabelNameDate(date) {
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
</style>
