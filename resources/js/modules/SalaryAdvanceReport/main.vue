<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="salaryAdvanceReport"
      nameLoading="table"
      :filter="false"
      :footer="false"
      bordered
    >
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td @click="onAction()">
            <ButtonAction class="cursor-pointer" type="click">
              <template v-slot:list_detail_button>
                <template v-if="getCan('perwakilan kasbon')">
                  <a
                    href="#"
                    v-if="item.approval_status == 'accept'"
                    @click="onApprove(item, 'accept_onbehalf')"
                  >Terima Perwakilan Direktur</a>
                </template>
                <template v-if="getApproval(item)">
                  <a href="#" @click="onApprove(item, 'accept')">Terima</a>
                  <a href="#" @click="onApprove(item, 'reject')">Tolak</a>
                </template>
                <a href="#" v-if="getCan('ubah kasbon')" @click="onEdit(item)">Ubah</a>
                <a href="#" v-if="getCan('hapus kasbon')" @click="onDelete(item)">Hapus</a>
              </template>
            </ButtonAction>
          </b-td>
          <b-td v-for="column in getColumns()" :key="column.label">
            <template v-if="column.field == 'approval_label'">
              <span
                :class="`badge bg-${item.approval_color}`"
                style="width:5rem"
              >{{item.approval_status_readable}}</span>
            </template>
            <template v-else>{{ item[column.field] }}</template>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

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
          label: "Nama Karyawan",
          field: "employee_name",
          width: "150px",
          class: "",
        },
        {
          label: "Jabatan",
          field: "position_name",
          width: "150px",
          class: "",
        },
        {
          label: "Mengajukan",
          field: "creator_name",
          width: "150px",
          class: "",
        },
        {
          label: "Nominal",
          field: "loan_amount_readable",
          width: "150px",
          class: "",
        },
        {
          label: "Alasan",
          field: "reason",
          width: "150px",
          class: "",
        },
        {
          label: "Sisa Hutang",
          field: "remaining_debt",
          width: "150px",
          class: "",
        },
        {
          label: "Status",
          field: "approval_label",
          width: "150px",
          class: "",
        },
        {
          label: "Keterangan",
          field: "approval_description",
          width: "150px",
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
      return this.$store.state.salaryAdvanceReport.data.main;
    },
    getIsLoadingData() {
      return this.$store.state.salaryAdvanceReport.loading.table;
    },
    params() {
      return this.$store.state.salaryAdvanceReport.params;
    },
  },
  watch: {
    getBaseUrl(value, oldValue) {
      if (value != null) {
        this.$store.dispatch("salaryAdvanceReport/fetchData", {
          user_id: this.getUserId,
        });
      }
    },
  },
  methods: {
    onAction() {
      //
    },
    onCreate(item) {
      this.$store.commit("salaryAdvanceReport/INSERT_FORM_FORM_TYPE", {
        form_type: "create",
        form_title: "Tambah Proyek",
      });
      this.$store.commit("salaryAdvanceReport/CLEAR_FORM");
      this.$bvModal.show("salary_advance_report_form");
    },
    onEdit(item) {
      this.$store.dispatch("salaryAdvanceReport/onAction", {
        form: item,
        form_type: "edit",
        form_title: "Ubah Proyek",
      });

      this.$bvModal.show("salary_advance_report_form");
    },
    onApprove(item, status) {
      console.info(item, status);
    },
    async onDelete(data) {
      const Swal = this.$swal;
      await Swal.fire({
        title: "Perhatian!!!",
        html: `Anda yakin ingin hapus Kasbon <h2><b>${data.employee_name}</b> senilai ${data.loan_amount_readable} ?</h2>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya hapus",
        cancelButtonText: "Batal",
      }).then(async (result) => {
        if (result.isConfirmed) {
          await axios
            .post(`${this.getBaseUrl}/api/v1/salary-advance/delete`, {
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

                this.$store.dispatch("salaryAdvanceReport/fetchData");
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
    getColumns() {
      const columns = this.columns.filter((item) => item.label != "");
      return columns;
    },
    getPermissionApproval(item) {
      let result = true;
      const approvalUsers = item.approval_user_id.map((value) => Number(value));
      // console.info(approvalUsers, Number(this.getUserId));

      if (!approvalUsers.includes(Number(this.getUserId))) {
        result = false;
      }

      return result;
    },
    getApproval(item) {
      let result = false;

      console.info(item);

      if (
        this.getCan("persetujuan kasbon") &&
        this.getPermissionApproval(item) &&
        item.approval_status != "not yet"
      ) {
        result = true;
      }

      return result;
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
