<template>
  <div>
    <b-modal
      id="data_employee"
      ref="data_employee"
      :title="getTitleForm"
      :size="getIsFormMobile ?'md' : 'lg'"
      class="modal-custom"
      hide-footer
    >
      <div v-if="getIsFormMobile">
        <FormMobile />
        <br />
        <TableMobile />
      </div>
      <div v-else>
        <FormDesktop />
        <br />
        <TableDesktop v-if="form.data_base == 'employee'" />
      </div>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button style="float: right" variant="success" @click="onSend()">Simpan</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import FormMobile from "./formMobile";
import FormDesktop from "./formDesktop";
import TableMobile from "./tableMobile";
import TableDesktop from "./tableDesktop";
export default {
  components: { TableMobile, FormMobile, TableDesktop, FormDesktop },
  data() {
    return {
      getTitleForm: "Data Karyawan",
    };
  },
  computed: {
    getIsFormMobile() {
      return this.$store.state.employee.is_form_mobile;
    },
    form() {
      return this.$store.state.employee.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("data_employee");
    },
    onSend() {
      this.$bvModal.hide("data_employee");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
