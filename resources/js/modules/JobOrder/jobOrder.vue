<template>
  <div style="height: 100%">
    <b-row style="height: 100%">
      <b-col v-if="!getIsMobile" col md="3" class></b-col>
      <b-col col :md="getIsMobile ? 12 : 6" id="main-content">
        <h3 style="display: inline">Job Order</h3>
        <Table />
      </b-col>
      <b-col v-if="!getIsMobile" col md="3" class></b-col>
    </b-row>
    <Form />
  </div>
</template>

<script>
import { isMobile } from "../../utils";
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";
import Table from "./table";
import Form from "./form";

export default {
  data() {
    return {
      title: "Job Order",
    };
  },
  components: {
    Table,
    Form,
    VueBottomSheet,
  },
  mounted() {
    // this.$bvModal.show("job_order_form");
  },
  computed: {
    getIsMobile() {
      return isMobile();
    },
  },
  methods: {
    onClose() {
      this.$refs.myBottomSheet.close();
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
