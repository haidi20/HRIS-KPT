<template>
  <div>
    <b-modal
      id="salary_adjustment_form"
      ref="salary_adjustment_form"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group label="Nama " label-for="name" class>
            <b-form-input v-model="form.name" id="name" name="name"></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Pilih Jenis Waktu" label-for="type_time" class>
            <VueSelect
              id="type_time"
              class="cursor-pointer"
              v-model="form.type_time"
              placeholder="Pilih Kategori"
              :options="getOptionTypeTimes"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row v-if="form.type_time == 'base time'">
        <b-col cols>
          <label for="scope_id" style="display:inline-block">
            <span>Pilih Bulan</span>
          </label>
          <DatePicker
            id="date_start"
            v-model="form.date_start"
            format="YYYY-MM"
            type="month"
            placeholder="pilih bulan"
          />
        </b-col>
        <b-col cols>
          <label for="scope_id">
            <b-form-checkbox style="display: inline" v-model="is_date_end"></b-form-checkbox>
            <span @click="onActiveDateEnd">Lebih dari 1 bulan</span>
          </label>
          <DatePicker
            v-if="is_date_end"
            id="date_end"
            v-model="form.date_end"
            format="YYYY-MM"
            type="month"
            placeholder="pilih bulan"
          />
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col cols>
          <b-form-group
            label="Pilih Jumlah Uang / Persentase dari Gaji Karyawan"
            label-for="type_amount"
            class
          >
            <VueSelect
              id="type_amount"
              class="cursor-pointer"
              v-model="form.type_amount"
              placeholder="Pilih Kategori"
              :options="getOptionTypeAmount"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="6">
          <b-form-group label="Nilai" label-for="amount" class>
            <b-form-input
              v-model="amount"
              id="amount"
              name="amount"
              @keypress="onReplaceAmount($event)"
            ></b-form-input>
            <span class="note">catatan: hanya berupa angka saja</span>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <label for="type_adjustment" style="display:inline-block; color: white;">
            <span>.</span>
          </label>
          <VueSelect
            id="type_adjustment"
            class="cursor-pointer"
            v-model="form.type_adjustment"
            placeholder="Pilih Jenis Penyesuaian"
            :options="getOptionTypeAdjustments"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="4">
          <b-form-group label="Pilih Karyawan" label-for="image" class>
            <b-button variant="success" @click="onShowEmployee()">Data Karyawan</b-button>
          </b-form-group>
        </b-col>
        <b-col cols="8">
          <b-form-group label="Keterangan" label-for="note" class>
            <b-form-input v-model="form.note" id="note" name="note" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <br />
      <b-row class="float-end">
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button variant="success" @click="onSend()" class="ml-8" :disabled="is_loading">Simpan</b-button>
          <span v-if="is_loading">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
    <Employee />
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import VueSelect from "vue-select";

import Employee from "../employee/view/employee";

export default {
  data() {
    return {
      is_loading: false,
      is_date_end: false,
      getTitleForm: "Tambah Penyesuaian Gaji",
    };
  },
  components: {
    VueSelect,
    DatePicker,
    Employee,
  },
  mounted() {
    this.$store.commit("employee/UPDATE_IS_FORM_MOBILE", {
      value: false,
    });
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getOptionTypeTimes() {
      return this.$store.state.salaryAdjustment.options.type_times;
    },
    getOptionTypeAmount() {
      return this.$store.state.salaryAdjustment.options.type_amounts;
    },
    getOptionTypeAdjustments() {
      return this.$store.state.salaryAdjustment.options.type_adjustments;
    },
    getEmployeeForm() {
      return this.$store.state.employee.form;
    },
    getEmployeeSelected() {
      return this.$store.state.employee.data.selecteds;
    },
    form() {
      return this.$store.state.salaryAdjustment.form;
    },
    amount: {
      get() {
        return this.$store.state.salaryAdjustment.form.amount_readable;
      },
      set(value) {
        this.$store.commit("salaryAdjustment/INSERT_FORM_AMOUNT", {
          amount: value,
        });
      },
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("salary_adjustment_form");
    },
    onChangeRangeMonth() {
      //
    },
    onActiveDateEnd() {
      this.is_date_end = !this.is_date_end;
    },
    onShowEmployee() {
      this.$bvModal.show("data_employee");
    },
    onReplaceAmount($event) {
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      //   console.info(keyCode);

      //   this.amount = this.amount.replace(/[^\d.:]/g, "");
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 44) {
        // 46 is dot
        $event.preventDefault();
      }
    },
    onSendOld() {
      console.info(this.form, this.getEmployeeForm, this.getEmployeeSelected);
      //   this.$bvModal.hide("salary_adjustment_form");
    },
    async onSend() {
      const Swal = this.$swal;

      // mengambil data hexa saja
      const request = {
        ...this.form,
        ...this.getEmployeeForm,
        employee_selected: this.getEmployeeSelected,
        user_id: this.getUserId,
      };

      this.is_loading = true;

      //   console.info(request);

      await axios
        .post(`${this.getBaseUrl}/api/v1/salary-adjustment/store`, request)
        .then((responses) => {
          console.info(responses);
          this.is_loading = false;
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

            // this.$bvModal.hide("salary_adjustment_form");
            // this.$store.dispatch("salaryAdjustment/fetchData");
            //     this.$store.commit("salaryAdjustment/CLEAR_FORM");
            //     this.$store.commit("employee/CLEAR_FORM");
            //     this.$store.commit("employee/CLEAR_DATA_SELECTED");
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
  },
};
</script>

<style lang="scss" scoped>
.note {
  color: red;
  font-size: 12px;
}
</style>
