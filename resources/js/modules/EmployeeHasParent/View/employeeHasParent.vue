<template>
  <div>
    <b-modal
      id="data_employee"
      ref="data_employee"
      :title="getTitleForm"
      :size="getIsMobile ?'md' : 'lg'"
      class="modal-custom"
      hide-footer
    >
      <template v-if="getIsMobile">
        <b-tabs content-class="mt-3">
          <b-tab title="Form">
            <FormMobile />
            <br />
            <TableMobile />
          </b-tab>
          <!-- <b-tab title="Data">
            <span>Data Karyawan</span>
          </b-tab>-->
        </b-tabs>
      </template>
      <template v-else>
        <FormDesktop />
        <br />
        <TableDesktop v-if="getForm.employee_base == 'choose_employee'" />
      </template>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            v-if="getConditionBtnSave()"
            style="float: right"
            variant="success"
            @click="onSave()"
          >Simpan</b-button>
          <span v-if="is_loading" style="float: right">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

import FormMobile from "./formMobile";
import TableMobile from "./tableMobile";
import FormDesktop from "./formDesktop";
import TableDesktop from "./tableDesktop";

export default {
  components: {
    TableMobile,
    FormMobile,
    TableDesktop,
    FormDesktop,
  },
  data() {
    return {
      is_loading: false,
      getTitleForm: "Data Karyawan",
    };
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getJobOrderFormKind() {
      return this.$store.state.jobOrder.form.form_kind;
    },
    getData() {
      return this.$store.state.employeeHasParent.data.selecteds;
    },
    getIsMobile() {
      return this.$store.state.employeeHasParent.is_mobile;
    },
    getForm() {
      return this.$store.state.employeeHasParent.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("data_employee");
    },
    onSave() {
      console.info(this.getJobOrderFormKind);

      if (this.getJobOrderFormKind == null) {
        this.onSend();
      } else {
        this.$bvModal.hide("data_employee");
      }
    },
    async onSend() {
      const Swal = this.$swal;

      let request = {
        data_employees: [...this.getData],
        user_id: this.getUserId,
      };

      console.info(request);

      await axios
        .post(
          `${this.getBaseUrl}/api/v1/job-order/store-action-has-employee`,
          request
        )
        .then((responses) => {
          console.info(responses);
          this.is_loading = false;
          // return false;
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

            this.$store.dispatch("jobOrder/fetchData");
            this.$bvModal.hide("data_employee");
          }
        })
        .catch((err) => {
          console.info(err);
          this.is_loading = false;

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
    getConditionBtnSave() {
      let result = false;

      //   console.info(this.getJobOrderFormKind);

      if (this.getForm.employee_base != "job_order") {
        result = true;
      }

      if (this.getJobOrderFormKind == "read") {
        result = false;
      }

      return result;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
