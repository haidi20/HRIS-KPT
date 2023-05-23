<template>
  <div>
    <b-modal
      id="salary_advance_approval_form"
      ref="salary_advance_approval_form"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <template v-if="form.approval_status == 'accept'">
        <b-row>
          <b-col cols="6">
            <span>
              <b>Total Pinjaman</b> :
            </span>
            <br />
            <span>{{form.loan_amount_readable}}</span>
          </b-col>
          <b-col cols="6">
            <span>
              <b>Sisa Pinjaman</b> :
            </span>
            <br />
            <span>{{form.remaining_debt_readable}}</span>
          </b-col>
        </b-row>
        <br />
        <!-- <b-row>
          <b-col cols>
            <b-form-group label label-for="type" class>
              <VueSelect
                id="type"
                class="cursor-pointer"
                v-model="form.type"
                :options="getOptionTypes"
                :reduce="(data) => data.id"
                label="name"
                searchable
                style="min-width: 180px"
              />
            </b-form-group>
          </b-col>
        </b-row>-->
        <b-row v-if="form.type == 'nominal'">
          <b-col cols="6">
            <b-form-group
              label="Nominal Potongan Per Bulan"
              label-for="monthly_deduction_amount"
              class
            >
              <b-form-input
                v-model="monthly_deduction_amount"
                id="monthly_deduction_amount"
                name="monthly_deduction_amount"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Potongan Setiap Bulan :" label-for="duration" class>
              <span>{{getDeductionFormula()}}</span>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row v-if="form.type == 'month'">
          <b-col cols="6">
            <b-form-group label="Lama Pembayaran (bulan)" label-for="duration" class>
              <b-form-input v-model="form.duration" id="duration" name="duration"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Potongan Setiap Bulan :" label-for="duration" class>
              <span>{{getDeductionFormula()}}</span>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col cols="12">
            <b-form-group label="Catatan" label-for="note" class>
              <b-form-input v-model="form.note" id="note" name="note"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </template>
      <b-row v-if="form.approval_status == 'reject'">
        <b-col cols="12">
          <b-form-group label="Alasan Menolak" label-for="note" class>
            <b-form-input v-model="form.note" id="note" name="note" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            style="float: right"
            variant="success"
            @click="onSend()"
            :disabled="is_loading"
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
import VueSelect from "vue-select";

export default {
  data() {
    return {
      is_loading: false,
      getTitleForm: "Persetujuan Kasbon",
    };
  },
  components: {
    VueSelect,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getOptionEmployees() {
      return this.$store.state.employee.data.options;
    },
    getOptionTypes() {
      return this.$store.state.salaryAdvanceReport.options.types;
    },
    form() {
      return this.$store.state.salaryAdvanceReport.form;
    },
    monthly_deduction_amount: {
      get() {
        return this.$store.state.salaryAdvanceReport.form
          .monthly_deduction_amount_readable;
      },
      set(value) {
        this.$store.commit(
          "salaryAdvanceReport/INSERT_FORM_MONTHLY_DEDUCTION_AMOUNT",
          {
            monthly_deduction_amount: value,
          }
        );
      },
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("salary_advance_approval_form");
    },
    async onSend() {
      const Swal = this.$swal;

      const request = {
        ...this.form,
        user_id: this.getUserId,
      };

      // console.info(request);
      this.is_loading = true;
      await axios
        .post(`${this.getBaseUrl}/api/v1/salary-advance/approval`, request)
        .then((responses) => {
          console.info(responses);

          this.is_loading = false;

          //   return false;
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

            this.$bvModal.hide("salary_advance_approval_form");
            this.$store.dispatch("salaryAdvanceReport/fetchData", {
              user_id: this.getUserId,
            });
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
    getDeductionFormula() {
      return this.$store.getters["salaryAdvanceReport/getDeductionFormula"];
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
