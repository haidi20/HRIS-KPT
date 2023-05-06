<template>
  <div style="height: 100%">
    <b-row style="height: 100%">
      <b-col v-if="!isMobile()" col md="3" class></b-col>
      <b-col col :md="isMobile() ? 12 : 6" id="main-content">
        <h3 style="display: inline">Kasbon</h3>
        <Table />
      </b-col>
      <b-col v-if="!isMobile()" col md="3" class></b-col>
    </b-row>
    <!-- <Form /> -->
  </div>
</template>

<script>
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";
import Table from "./table";
import Form from "./form";

export default {
  data() {
    return {
      title: "Kasbon",
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
  methods: {
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
  border-radius: 30px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
