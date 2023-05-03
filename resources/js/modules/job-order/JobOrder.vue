<template>
  <div>
    <b-row>
      <b-col v-if="!isMobile()" col md="3" class></b-col>
      <b-col col :md="isMobile() ? 12 : 6">
        <h3 style="display: inline">Job Order</h3>
        <b-button variant="success" size="sm" class="float-end" @click="onCreate()">Tambah</b-button>
        <Table />
      </b-col>
      <b-col v-if="!isMobile()" col md="3" class></b-col>
    </b-row>
    <Form />
  </div>
</template>

<script>
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";
import Table from "./Table";
import Form from "./Form";

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
  methods: {
    onCreate() {
      //   console.info("create");
      this.$bvModal.show("form_job_order");
    },
    onClose() {
      this.$refs.myBottomSheet.close();
    },
    isMobile() {
      if (screen.width <= 760) {
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
