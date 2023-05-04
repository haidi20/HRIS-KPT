<template>
  <div>
    <b-modal
      id="data_employee"
      ref="data_employee"
      :title="getTitleForm"
      size="lg"
      class="modal-custom"
      hide-footer
    >
      <Form />
      <br />
      <Table />
    </b-modal>
  </div>
</template>

<script>
import Form from "./Form.vue";
import Table from "./Table.vue";
export default {
  components: { Table, Form },
  data() {
    return {
      getTitleForm: "Data Karyawan",
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
