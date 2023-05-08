<template>
  <div>
    <b-modal
      id="vacation_form"
      ref="vacation_form"
      :title="getTitleForm"
      size="md"
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
      <br />
      <b-row class="float-end">
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button variant="success" @click="onSend()" class="ml-8" :disabled="is_loading">Simpan</b-button>
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
      getTitleForm: "Tambah Cuti",
    };
  },
  components: {
    VueSelect,
  },
  computed: {
    getOptionEmployees() {
      return this.$store.state.employee.data.options;
    },
    form() {
      return this.$store.state.vacation.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("vacation_form");
    },
    onSend() {
      console.info(this.form.employee_id);
      this.$bvModal.hide("vacation_form");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
