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
          <b-td>{{ item.company_name }}</b-td>
          <b-td>
            {{ item.job_order_total }}
            \ {{ item.job_order_total_finish }}
          </b-td>
          <b-td>
            <b-button variant="primary" size="sm" @click="onDetail(item)">Detail</b-button>
            <b-button variant="warning" size="sm" @click="onShowJobOrder(item)">Job Order</b-button>
            <b-button variant="info" size="sm" @click="onEdit(item)">Ubah</b-button>
            <b-button variant="danger" size="sm" @click="onDelete(item)">Hapus</b-button>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
    <JobOrderModal />
  </div>
</template>

<script>
import JobOrderModal from "../JobOrder/modal";
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
          label: "Perusahaan",
          field: "company_name",
          width: "100px",
          class: "",
        },
        {
          label: "Total Job Order",
          field: "job_order_total",
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
    JobOrderModal,
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
    onDetail() {
      this.$bvModal.show("project_form");
    },
    onEdit() {
      this.$bvModal.show("project_form");
    },
    onShowJobOrder() {
      this.$bvModal.show("job_order_modal");
    },
    onDelete() {
      //
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
