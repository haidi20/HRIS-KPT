<template>
  <div>
    <b-row>
      <b-col cols>
        <b-form-group label="Jabatan" label-for="position_id" class>
          <VueSelect
            id="position_id"
            class="cursor-pointer"
            v-model="form.position_id"
            placeholder="Pilih Jabatan"
            :options="getOptionPositions"
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
        <b-form-group label="Karyawan" label-for="employee_id" class>
          <VueSelect
            id="employee_id"
            class="cursor-pointer"
            v-model="form.employee_id"
            placeholder="Pilih Karyawan"
            :options="getOptionEmployees"
            :reduce="(data) => data.id"
            label="name_and_position"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
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
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getOptionPositions() {
      return this.$store.state.master.data.positions;
    },
    getOptionEmployees() {
      return this.$store.state.employeeHasParent.data.options;
    },
    form() {
      return this.$store.state.employeeHasParent.form;
    },
  },
  methods: {
    onSend() {
      console.info(this.form.employee_id);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
