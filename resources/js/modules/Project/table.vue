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
          <b-form-group label="Bulan Selesai Proyek" label-for="month" class="place_filter_table">
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
          <b-button
            v-if="getCan('ekspor proyek')"
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
          <b-button
            v-if="getCan('tambah proyek')"
            variant="success"
            class="place_filter_table ml-4"
            size="sm"
            @click="onCreate()"
          >
            <i class="fas fa-plus"></i>
            Tambah
          </b-button>
        </b-col>
      </template>
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td @click="onAction()">
            <ButtonAction class="cursor-pointer" type="click">
              <template v-slot:list_detail_button>
                <a
                  href="#"
                  v-if="getCan('lihat proyek')"
                  @click="onDetail(item, index)"
                >Informasi Lengkap</a>
                <a href="#" v-if="getCan('ubah proyek')" @click="onEdit(item)">Ubah</a>
                <a href="#" v-if="getCan('hapus proyek')" @click="onDelete(item)">Hapus</a>
              </template>
            </ButtonAction>
            <!-- <b-button variant="primary" size="sm" @click="onDetail(item)">Detail</b-button>
            <b-button variant="warning" size="sm" @click="onShowJobOrder(item)">Job Order</b-button>
            <b-button variant="info" size="sm" @click="onEdit(item)">Ubah</b-button>
            <b-button variant="danger" size="sm" @click="onDelete(item)">Hapus</b-button>-->
            <!-- <b-dropdown size="sm" left split text="Tombol" varian="info">
              <b-list-group>
                <b-list-group-item class="cursor-pointer">Semua Informasi</b-list-group-item>
                <b-list-group-item class="cursor-pointer">Job Order</b-list-group-item>
                <b-list-group-item class="cursor-pointer">Ubah</b-list-group-item>
                <b-list-group-item class="cursor-pointer">Hapus</b-list-group-item>
              </b-list-group>
            </b-dropdown>-->
          </b-td>
          <b-td>{{ item.name }}</b-td>
          <b-td>{{ item.company_name }}</b-td>
          <b-td>{{ item.date_end_readable }}</b-td>
          <b-td>{{ item.day_duration }} Hari</b-td>
          <b-td>
            <template v-if="item.job_order_total > 0">
              {{ item.job_order_total_finish }}
              \ {{ item.job_order_total }}
            </template>
            <template v-else>
              <span>belum ada job order</span>
            </template>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
    <JobOrderModal />
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

import JobOrderModal from "../JobOrder/modal";
import DatatableClient from "../../components/DatatableClient";
import ButtonAction from "../../components/ButtonAction";

export default {
  data() {
    return {
      is_loading_export: false,
      columns: [
        {
          label: "",
          class: "",
          width: "10px",
        },
        {
          label: "Nama",
          field: "name",
          width: "150px",
          class: "",
        },
        {
          label: "Perusahaan",
          field: "company_name",
          width: "200px",
          class: "",
        },
        {
          label: "Tanggal Selesai",
          field: "date_end",
          width: "200px",
          class: "",
        },
        {
          label: "Jangka Waktu Pekerjaan",
          field: "duration",
          width: "200px",
          class: "",
        },
        {
          label: "Total Job Order",
          field: "job_order_total",
          width: "200px",
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
    ButtonAction,
    JobOrderModal,
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
    getIsLoadingData() {
      return this.$store.state.project.loading.table;
    },
    params() {
      return this.$store.state.project.params;
    },
  },
  methods: {
    onAction() {
      //
    },
    onCreate(item) {
      this.$store.commit("project/INSERT_FORM_FORM_TYPE", {
        form_type: "create",
        form_title: "Tambah Proyek",
      });
      this.$store.commit("project/CLEAR_FORM");
      this.$bvModal.show("project_form");
    },
    onDetail(item) {
      //   console.info(item);
      this.$store.dispatch("project/onAction", {
        form: item,
        form_type: "detail",
        form_title: "Informasi Lengkap Proyek",
      });

      this.$store.commit("jobOrder/INSERT_PARAM", { project_id: item.id });
      this.$store.dispatch("jobOrder/fetchData");

      this.$bvModal.show("project_form");
    },
    onEdit(item) {
      this.$store.dispatch("project/onAction", {
        form: item,
        form_type: "edit",
        form_title: "Ubah Proyek",
      });

      this.$store.commit("jobOrder/INSERT_PARAM", { project_id: item.id });
      this.$store.dispatch("jobOrder/fetchData");

      this.$bvModal.show("project_form");
    },
    onShowJobOrder() {
      this.$bvModal.show("job_order_modal");
    },
    onFilter() {
      this.$store.dispatch("project/fetchData");
    },
    async onExport() {
      const Swal = this.$swal;
      this.is_loading_export = true;

      await axios
        .get(`${this.getBaseUrl}/project/export`, {
          params: {
            ...this.params,
            user_id: this.getUserId,
            month: moment(this.params.month).format("Y-MM"),
          },
        })
        .then((responses) => {
          console.info(responses);
          this.is_loading_export = false;
          const data = responses.data;

          //   return false;

          if (data.success) {
            window.open(data.linkDownload, "_blank");
          }
        })
        .catch((err) => {
          this.is_loading_export = false;
          console.info(err);
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });
          Toast.fire({
            icon: "error",
            title: err.response.data.message,
          });
        });
    },
    async onDelete(data) {
      const Swal = this.$swal;
      await Swal.fire({
        title: "Perhatian!!!",
        html: `Anda yakin ingin hapus Proyek <h2><b>${data.name}</b> ?</h2>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya hapus",
        cancelButtonText: "Batal",
      }).then(async (result) => {
        if (result.isConfirmed) {
          await axios
            .post(`${this.getBaseUrl}/api/v1/project/delete`, {
              id: data.id,
              user_id: this.getUserId,
            })
            .then((responses) => {
              //   console.info(responses);
              const data = responses.data;

              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener("mouseenter", Swal.stopTimer);
                  toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
              });

              if (data.success == true) {
                Toast.fire({
                  icon: "success",
                  title: data.message,
                });

                this.$store.dispatch("project/fetchData");
              }
            })
            .catch((err) => {
              console.info(err);

              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener("mouseenter", Swal.stopTimer);
                  toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
              });

              Toast.fire({
                icon: "error",
                title: err.response.data.message,
              });
            });
        }
      });
    },
    getCan(permissionName) {
      const getPermission = this.$store.getters["getCan"](permissionName);

      return getPermission;
    },
  },
};
</script>

<style lang="scss" scoped>
.place_filter_table {
  align-items: self-end;
  margin-bottom: 0;
  display: inline-block;
}
</style>
