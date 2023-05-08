<template>
  <div>
    <b-row>
      <b-col cols="4">
        <b-form-group label="Pilih Karyawan Berdasarkan" label-for="data_base" class>
          <VueSelect
            id="data_base"
            class="cursor-pointer"
            v-model="form.data_base"
            :options="getOptionDataBases"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
      <b-col cols="8">
        <b-form-group
          v-if="form.data_base == 'employee'"
          label="Karyawan"
          label-for="employee_id"
          class
        >
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
        <b-form-group
          v-if="form.data_base == 'position'"
          label="Departemen"
          label-for="position_id"
          class
        >
          <VueSelect
            id="position_id"
            class="cursor-pointer"
            v-model="form.position_id"
            placeholder="Pilih Departemen"
            :options="getOptionPositions"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row v-if="form.data_base == 'employee'">
      <b-col cols style="text-align: right">
        <b-button variant="success" @click="onSend()">Pilih</b-button>
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
    getOptionDataBases() {
      return this.$store.state.employee.options.data_bases;
    },
    getOptionEmployees() {
      return this.$store.state.employee.data.options;
    },
    getOptionPositions() {
      return this.$store.state.employee.data.positions;
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
