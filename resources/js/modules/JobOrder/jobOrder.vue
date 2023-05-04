<template>
  <div style="height: 100%">
    <b-row style="height: 100%">
      <b-col v-if="!isMobile()" col md="3" class></b-col>
      <b-col col :md="isMobile() ? 12 : 6" id="main-content">
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
    // this.$bvModal.show("form_job_order");
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
#main-content {
  background-color: white;
  height: 100%;
  padding-top: 20px;
}
</style>
