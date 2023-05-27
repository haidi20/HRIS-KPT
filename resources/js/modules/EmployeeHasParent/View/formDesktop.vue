<template>
  <div>
    <b-row>
      <b-col cols="4">
        <b-form-group label="Pilih Karyawan Berdasarkan" label-for="employee_base" class>
          <VueSelect
            id="employee_base"
            class="cursor-pointer"
            v-model="form.employee_base"
            :options="getOptionEmplyeeBases"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
      <b-col cols="8">
        <b-form-group
          v-if="form.employee_base == 'choose_employee'"
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
            label="name_and_position"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
        <b-form-group
          v-if="form.employee_base == 'position'"
          label="Jabatan"
          label-for="position_id"
          class
        >
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
        <b-form-group
          v-if="form.employee_base == 'job_order'"
          label="Job Order"
          label-for="job_order_id"
          class
        >
          <VueSelect
            id="job_order_id"
            class="cursor-pointer"
            v-model="form.job_order_id"
            placeholder="Pilih Job Order"
            :options="getOptionJobOrders"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row v-if="form.employee_base == 'choose_employee'">
      <b-col cols style="text-align: right">
        <b-button variant="success" @click="onChoose()">Pilih</b-button>
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
    getOptionEmplyeeBases() {
      return this.$store.state.employeeHasParent.options.employee_bases;
    },
    getOptionEmployees() {
      return this.$store.state.employeeHasParent.data.options;
    },
    getOptionPositions() {
      return this.$store.state.master.data.positions;
    },
    getOptionJobOrders() {
      return this.$store.state.jobOrder.data.map((item) => ({
        ...item,
        name: item.project_name,
      }));
    },
    getData() {
      return this.$store.state.employeeHasParent.data.selecteds;
    },
    form() {
      return this.$store.state.employeeHasParent.form;
    },
  },
  methods: {
    onChoose() {
      if (this.form.employee_id == null || this.form.employee_id == "")
        return false;

      const checkData = this.getData.find(
        (item) => item.employee_id == this.form.employee_id
      );

      // jika sudah ada datanya tidak perlu di masukkan lagi
      if (!checkData) {
        const getEmployee = this.getOptionEmployees.find(
          (item) => item.id == this.form.employee_id
        );

        //   console.info(getEmployee);
        this.$store.commit("employeeHasParent/INSERT_DATA_SELECTED", {
          employee: {
            employee_id: getEmployee.id,
            employee_name: getEmployee.name,
            position_name: getEmployee.position_name,
          },
        });
      } else {
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

        console.info(checkData);

        Toast.fire({
          icon: "warning",
          title: `Maaf, karyawan atas nama ${checkData.employee_name} sudah dipilih`,
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
