<template>
  <div>
    <b-row>
      <b-col cols>
        <b-form-group label="Tanggal" label-for="Tanggal" class>
          <DatePicker
            id="date"
            v-model="form.date"
            format="YYYY-MM-DD"
            type="date"
            placeholder="pilih Tanggal"
            disabled
          />
        </b-form-group>
      </b-col>
      <b-col cols>
        <b-form-group label="Jam" label-for="hour" class>
          <input type="time" v-model="form.hour" id="hour" name="hour" class="form-control" />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols>
        <b-form-group label="Masukkan Foto" label-for="image" class>
          <b-form-file id="image" v-model="form.image"></b-form-file>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row v-if="getKindForm == 'overtime'">
      <b-col col sm="6">
        <b-form-group label="Pilih Karyawan" label-for="image" class>
          <b-button variant="success" @click="onShowEmployee()">Data Karyawan</b-button>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols>
        <b-form-group label="Catatan" label-for="note" class>
          <b-form-input type="text" v-model="form.note" id="note" name="note" class="form-control" />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
        <b-button
          style="float: right"
          variant="success"
          @click="onSend()"
          :disabled="is_loading"
        >Simpan</b-button>
        <span v-if="is_loading">Loading...</span>
      </b-col>
    </b-row>
    <EmployeeHasParent />
  </div>
</template>

<script>
import axios from "axios";
import EmployeeHasParent from "../EmployeeHasParent/view/employeeHasParent";
export default {
  data() {
    return {
      is_loading: false,
    };
  },
  components: {
    EmployeeHasParent,
  },
  computed: {
    getTitleForm() {
      return this.$store.state.jobOrder.form.form_title;
    },
    getKindForm() {
      return this.$store.state.jobOrder.form.form_kind;
    },
    form() {
      return this.$store.state.jobOrder.form;
    },
  },
  methods: {
    onShowEmployee() {
      this.$bvModal.show("data_employee");
    },
    onCloseModal() {
      this.$store.commit("jobOrder/INSERT_FORM_KIND", {
        form_title: "Job Order",
        form_kind: null,
      });
      this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
        value: false,
      });
      this.$bvModal.hide("job_order_form_action");
    },
    onSend() {
      this.$store.commit("jobOrder/INSERT_FORM_KIND", {
        form_title: "Job Order",
        form_kind: null,
      });
      this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
        value: false,
      });
      this.$bvModal.hide("job_order_form_action");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
