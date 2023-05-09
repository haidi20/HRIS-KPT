<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="rosterStatus"
      nameLoading="table"
      :filter="true"
      :footer="false"
      bordered
    >
      <template v-slot:filter>
        <b-col cols>
          <b-button variant="success" size="sm" @click="onCreate()">Tambah</b-button>
        </b-col>
      </template>
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td>{{ item.name }}</b-td>
          <b-td>{{ item.initial }}</b-td>
          <b-td>{{ item.note }}</b-td>
          <b-td :style="{backgroundColor: item.color}">
            <p :style="{ color: item.color }">.</p>
          </b-td>
          <b-td>
            <b-button variant="info" size="sm" @click="onEdit(item.id)">Ubah</b-button>
            <b-button variant="danger" size="sm" @click="onDelete(item.id)">Hapus</b-button>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
    <Form />
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";

import DatatableClient from "../../components/DatatableClient";
import Form from "./form";

export default {
  data() {
    return {
      columns: [
        {
          label: "Nama",
          field: "name",
          width: "100px",
          class: "",
        },
        {
          label: "Nama Inisial",
          field: "initial",
          width: "100px",
          class: "",
        },
        {
          label: "Catatan",
          field: "note",
          width: "100px",
          class: "",
        },
        {
          label: "Warna",
          field: "color",
          width: "100px",
          class: "",
        },
        {
          label: "",
          class: "",
          width: "10px",
        },
      ],
      options: {
        perPage: 5,
        // perPageValues: [5, 10, 25, 50, 100],
      },
    };
  },
  components: {
    Form,
    DatePicker,
    DatatableClient,
  },
  computed: {
    getData() {
      return this.$store.state.rosterStatus.data;
    },
  },
  methods: {
    onEdit(id) {
      this.$store.commit("rosterStatus/INSERT_FORM", {
        form: { ...this.getData.find((item) => item.id == id) },
      });
      this.$bvModal.show("roster_status_form");
    },
    onCreate() {
      this.$bvModal.show("roster_status_form");
    },
    customLabel(color) {
      return {
        backgroundColor: color,
      };
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
