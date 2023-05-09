<template>
  <div>
    <DatatableClient
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
          <b-form-group label="Bulan" label-for="month_filter" class="place_filter_table">
            <DatePicker
              id="month_filter"
              v-model="form.month_filter"
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
            :disabled="getIsLoadingFilter"
          >Kirim</b-button>
          <span v-if="getIsLoadingFilter">Loading...</span>
          <b-button
            class="place_filter_table ml-4"
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
      <template v-slot:thead>
        <b-th
          v-for="(item, index) in getDateRanges"
          v-bind:key="`thead-${index}`"
          style="width: 30px"
        >{{ onCustomLabelDate(item) }}</b-th>
      </template>
      <template v-slot:theadSecond>
        <b-th
          v-for="(item, index) in getDateRanges"
          v-bind:key="`thead-${index}`"
          style="text-align-last: center"
        >{{ onCustomLabelNameDate(item) }}</b-th>
      </template>
      <template v-slot:tbody="{ filteredData, currentPage }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td nowrap>
            <b-button variant="info" size="sm" @click="onEdit(item.id)">Ubah</b-button>
          </b-td>
          <b-td nowrap>{{ item.employee_name }}</b-td>
          <b-td
            class="cursor-pointer text-center"
            v-for="(date, subIndex) in getDateRanges"
            :key="`date-${subIndex}`"
            :style="setStyling(
                getNoTable(index, currentPage, options.perPage),
                date,
                item[date]?.color
            )"
          >{{ item[date]?.value }}</b-td>
        </b-tr>
      </template>
    </DatatableClient>
    <Form />
  </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import DatatableClient from "../../../components/DatatableClient";
import Form from "./form";

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
          field: "actions",
          width: "10px",
          rowspan: 2,
          class: "",
        },
        {
          label: "Nama Karyawan",
          field: "employee_name",
          width: "100px",
          rowspan: 2,
          class: "",
        },
      ],
    };
  },
  components: {
    Form,
    DatePicker,
    DatatableClient,
  },
  computed: {
    getData() {
      return this.$store.state.roster.data;
    },
    getDateRanges() {
      return this.$store.state.roster.date_ranges;
    },
    getIsLoadingFilter() {
      return this.$store.state.roster.loading.table;
    },
    form() {
      return this.$store.state.roster.form;
    },
  },
  methods: {
    onFilter() {
      this.$store.dispatch("roster/fetchData");
    },
    onEdit(id) {
      this.$store.commit("roster/INSERT_FORM", { id: id });
      this.$bvModal.show("roster_form");
    },
    onCustomLabelDate(date) {
      return moment(date).format("DD");
    },
    onCustomLabelNameDate(date) {
      return moment(date).format("dddd");
    },
    getNoTable(index, currentPage, perPage) {
      return index + 1 + (currentPage - 1) * perPage;
    },
    setStyling(index, date, color) {
      // console.info(index, date);
      let style = {};

      if (color != null) {
        style = {
          backgroundColor: color,
        };
      } else {
        // style = this.getBackgroundColor(index, date);
        style = {
          backgroundColor: "white",
        };
      }

      return style;
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
