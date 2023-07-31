<template>
  <div>
    <b-modal
      id="detail_modal"
      ref="detail_modal"
      :title="title"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col>
          <DatatableClient
            :data="getData"
            :columns="columns"
            :options="options"
            nameStore="attendance"
            nameLoading="detail"
            :filter="false"
            :footer="false"
            bordered
          >
            <template v-slot:tbody="{ filteredData }">
              <b-tr v-for="(item, index) in filteredData" :key="index">
                <b-td>{{item.datetime_readable}}</b-td>
              </b-tr>
            </template>
          </DatatableClient>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import DatatableClient from "../../components/DatatableClient";

export default {
  data() {
    return {
      is_loading: false,
      title: "Daftar jam absensi",
      options: {
        perPage: 5,
        // perPageValues: [5, 10, 25, 50, 100],
      },
      columns: [
        {
          label: "Waktu",
          field: "datetime_readable",
          width: "200px",
          class: "",
        },
      ],
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
      return this.$store.state.user.id;
    },
    getData() {
      return this.$store.state.attendance.data.detail;
    },
    getLoading() {
      return this.$store.state.attendance.loading.base_employee;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("detail_modal");
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
