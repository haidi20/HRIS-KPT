<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="project"
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
            <b-button variant="info" size="sm" @click="onEdit(item)">Ubah</b-button>
            <b-button variant="danger" size="sm" @click="onDelete(item)">Hapus</b-button>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import DatatableClient from "../../components/DatatableClient";

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
      return this.$store.state.project.data;
    },
    form() {
      return this.$store.state.project.form;
    },
  },
  methods: {
    onCreate() {
      this.$bvModal.show("project_form");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
