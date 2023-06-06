<template>
  <div>
    <b-modal
      id="data_employee"
      ref="data_employee"
      :title="getTitleForm"
      :size="getIsMobile ?'md' : 'lg'"
      class="modal-custom"
      hide-footer
    >
      <template v-if="getIsMobile">
        <b-tabs content-class="mt-3">
          <b-tab title="Form">
            <FormMobile />
            <br />
            <TableMobile />
          </b-tab>
          <!-- <b-tab title="Data">
            <span>Data Karyawan</span>
          </b-tab>-->
        </b-tabs>
      </template>
      <template v-else>
        <FormDesktop />
        <br />
        <TableDesktop v-if="form.employee_base == 'choose_employee'" />
      </template>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            v-if="form.employee_base != 'job_order'"
            style="float: right"
            variant="success"
            @click="onSend()"
          >Simpan</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import FormMobile from "./formMobile";
import TableMobile from "./tableMobile";
import FormDesktop from "./formDesktop";
import TableDesktop from "./tableDesktop";

export default {
  components: {
    TableMobile,
    FormMobile,
    TableDesktop,
    FormDesktop,
  },
  data() {
    return {
      getTitleForm: "Data Karyawan",
    };
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getJobOrderFormKind() {
      return this.$store.state.jobOrder.form.form_kind;
    },
    getIsMobile() {
      return this.$store.state.employeeHasParent.is_mobile;
    },
    form() {
      return this.$store.state.employeeHasParent.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("data_employee");
    },
    onSend() {
      console.info(this.getJobOrderFormKind);
      this.$bvModal.hide("data_employee");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
