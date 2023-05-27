<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="salaryAdjustment"
      nameLoading="table"
      :filter="true"
      :footer="false"
      bordered
    >
      <template v-slot:filter>
        <b-col cols>
          <b-form-group label="Tanggal" label-for="date" class="place_filter_table">
            <DatePicker
              id="date"
              v-model="params.date"
              format="YYYY-MM"
              type="month"
              placeholder="pilih tanggal"
              range
            />
          </b-form-group>
          <b-button class="place_filter_table" variant="success" size="sm" @click="onFilter()">Kirim</b-button>
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
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td v-for="column in getColumns()" :key="column.label">{{ item[column.field] }}</b-td>
          <b-td>
            <!-- <a href="#" @click="onDelete(item)" class="fomr-control">Hapus</a> -->
            <b-button variant="primary" size="sm" @click="onDetail(item)">Detail</b-button>
            <b-button variant="info" size="sm" @click="onEdit(item)">Ubah</b-button>
            <b-button
              v-if="item.created_by == getUserId"
              variant="danger"
              size="sm"
              @click="onDelete(item.id)"
            >Hapus</b-button>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import DatatableClient from "../../../components/DatatableClient";

export default {
  data() {
    return {
      is_loading_export: false,
      columns: [
        {
          label: "Nama",
          field: "name",
          width: "100px",
          class: "",
        },
        {
          label: "Waktu",
          field: "type_time_readable",
          width: "100px",
          class: "",
        },
        {
          label: "Nilai",
          field: "amount_readable",
          width: "100px",
          class: "",
        },
        {
          label: "Jenis",
          field: "type_adjustment_name",
          width: "100px",
          class: "",
        },
        {
          label: "Keterangan",
          field: "note",
          width: "100px",
          class: "",
        },
        {
          label: "",
          class: "",
          width: "20px",
        },
      ],
      options: {
        perPage: 5,
        // perPageValues: [5, 10, 25, 50, 100],
      },
    };
  },
  components: {
    DatePicker,
    DatatableClient,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.salaryAdjustment.data;
    },
    params() {
      return this.$store.state.salaryAdjustment.params;
    },
  },
  methods: {
    onExport() {
      //
    },
    onDetail(form) {
      //   this.$store.commit("salaryAdjustment/CLEAR_FORM");
      this.$bvModal.show("salary_adjustment_form");
      this.$store.commit("salaryAdjustment/INSERT_FORM", {
        form,
        form_type: "detail",
      });
    },
    onEdit(form) {
      //   this.$store.commit("salaryAdjustment/CLEAR_FORM");
      this.$bvModal.show("salary_adjustment_form");
      this.$store.commit("salaryAdjustment/INSERT_FORM", {
        form,
        form_type: "edit",
      });
    },
    onDelete(id) {
      //
    },
    onFilter() {
      console.info(this.params);
    },
    getColumns() {
      const columns = this.columns.filter((item) => item.label != "");
      return columns;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
