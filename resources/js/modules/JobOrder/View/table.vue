<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="jobOrder"
      nameLoading="table"
      :filter="false"
      :footer="false"
      bordered
    >
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td v-for="column in getColumns()" :key="column.label">{{ item[column.field] }}</b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import DatatableClient from "../../../components/DatatableClient";

export default {
  data() {
    return {
      columns: [
        {
          label: "Nama Proyek",
          field: "proyek_name",
          width: "100px",
          class: "",
        },
        {
          label: "Pekerjaan",
          field: "job_name",
          width: "100px",
          class: "",
        },
        {
          label: "Pengawas",
          field: "foreman_name",
          width: "100px",
          class: "",
        },
        {
          label: "Waktu Selesai",
          field: "time_end_readable",
          width: "100px",
          class: "",
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
      return this.$store.state.jobOrder.data;
    },
  },
  methods: {
    getColumns() {
      const columns = this.columns.filter((item) => item.label != "");
      return columns;
    },
    getPermissionAdd() {
      return true;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
