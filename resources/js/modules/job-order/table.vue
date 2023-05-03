<template>
  <div>
    <b-row style="margin-top: 10px">
      <b-col cols>
        <input type="text" placeholder="search..." style="width: 100%" class="form-control" />
      </b-col>
    </b-row>
    <br />
    <b-row>
      <b-col class="place-data">
        <b-row v-for="i in 3" :key="i">
          <b-col class="place-item" @click="onOpenAction(i)">
            <h5>Perbaikan Kapal Bagian Belakang</h5>
            <h6>Total Karyawan : 5</h6>
            <!--  -->
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet">actions</vue-bottom-sheet>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
    };
  },
  methods: {
    onOpenAction(i) {
      //   console.info(i);
      this.$refs.myBottomSheet.open();
    },
  },
};
</script>

<style lang="scss" scoped>
.place-data {
  max-height: 500px;
  overflow-x: scroll;
}
.place-item {
  border-bottom: 1px solid #dbdfea;
  padding: 0.5rem;
}
</style>
