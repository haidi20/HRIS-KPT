<template>
  <div style="height: 100%">
    <b-row style="height: 100%">
      <b-col v-if="!getIsMobile" col md="3" class></b-col>
      <b-col col :md="getIsMobile ? 12 : 6" id="main-content">
        <h3 style="display: inline">{{getTitle}}</h3>
        <template v-if="!getIsActiveForm">
          <Table />
        </template>
        <template v-else>
          <template v-if="getConditionForm()">
            <Form />
          </template>
          <template v-else>
            <FormAction />
          </template>
        </template>
      </b-col>
      <b-col v-if="!getIsMobile" col md="3" class></b-col>
    </b-row>
  </div>
</template>

<script>
import { isMobile } from "../../utils";
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";
import Table from "./table";
import Form from "./form";
import FormAction from "./formAction.vue";

export default {
  data() {
    return {
      //
    };
  },
  components: {
    Table,
    Form,
    FormAction,
    VueBottomSheet,
  },
  mounted() {
    // this.$bvModal.show("job_order_form");
  },
  computed: {
    getIsMobile() {
      return isMobile();
    },
    getIsActiveForm() {
      return this.$store.state.jobOrder.is_active_form;
    },
    getTitle() {
      return this.$store.state.jobOrder.form.form_title;
    },
    form() {
      return this.$store.state.jobOrder.form;
    },
  },
  methods: {
    onClose() {
      this.$refs.myBottomSheet.close();
    },
    getConditionForm() {
      return (
        this.form.form_kind == "edit" ||
        this.form.form_kind == "detail" ||
        this.form.form_kind == "create"
      );
    },
  },
};
</script>

<style lang="scss" scoped>
#main-content {
  background-color: white;
  max-height: 90%;
  padding-top: 20px;
  border-radius: 30px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
