<template>
  <div>
    <b-row>
      <b-col v-if="!isMobile()" col md="3" class></b-col>
      <b-col col :md="isMobile() ? 12 : 6">
        <b-button variant="success" size="sm" @click="onOpen">show / hide</b-button>
        <vue-bottom-sheet ref="myBottomSheet">actions</vue-bottom-sheet>
      </b-col>
      <b-col v-if="!isMobile()" col md="3" class></b-col>
    </b-row>
  </div>
</template>

<script>
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";

export default {
  data() {
    return {
      title: "Job Order",
    };
  },
  components: {
    VueBottomSheet,
  },
  methods: {
    isMobile() {
      if (screen.width <= 760) {
        return true;
      } else {
        return false;
      }
    },
    onOpen() {
      this.$refs.myBottomSheet.open();
    },
    onClose() {
      this.$refs.myBottomSheet.close();
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
