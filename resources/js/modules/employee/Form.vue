<template>
  <div>
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
      <b-col cols style="text-align: right">
        <b-button variant="success" @click="onSend()">Tambah</b-button>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import VueSelect from "vue-select";

export default {
  components: {
    VueSelect,
  },
  computed: {
    getOptionEmployees() {
      return this.$store.state.employee.data.main;
    },
    form() {
      return this.$store.state.employee.form;
    },
  },
  methods: {
    onSen() {
      console.info(this.form.employee_id);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
