<template>
  <div>
    <b-modal
      id="salary_advance_form"
      ref="salary_advance_form"
      :title="getTitleForm"
      size="lg"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group label="Karyawan" label-for="employee_id" class>
            <VueSelect
              id="employee_id"
              class="cursor-pointer"
              v-model="form.employee_id"
              placeholder="Pilih Karyawan"
              :options="getOptionEmployees"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Jumlah kasbon" label-for="amount" class>
            <b-form-input v-model="amount" id="amount" name="amount"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Alasan" label-for="reason" class>
            <b-form-input v-model="form.reason" id="reason" name="reason"></b-form-input>
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
          <span v-if="is_loading">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import VueSelect from "vue-select";

export default {
  data() {
    return {
      is_loading: false,
      getTitleForm: "Buat Kasbon",
    };
  },
  components: {
    VueSelect,
  },
  computed: {
    getOptionEmployees() {
      return this.$store.state.employee.data.main;
    },
    form() {
      return this.$store.state.salaryAdvance.form;
    },
    amount: {
      get() {
        return this.$store.state.salaryAdvance.form.amount_readable;
      },
      set(value) {
        this.$store.commit("salaryAdvance/INSERT_FORM_AMOUNT", {
          amount: value,
        });
      },
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("salary_advance_form");
    },
    onSend() {
      this.$bvModal.hide("salary_advance_form");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
