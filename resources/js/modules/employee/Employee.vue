<template>
  <div>
    <b-modal
      id="data_employee"
      ref="data_employee"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      data Karyawan
      <!--  -->
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      getTitleForm: "Data Karyawan",
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
