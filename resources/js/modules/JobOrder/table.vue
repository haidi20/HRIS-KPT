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
            <span>Total Karyawan : 5</span>
            <br />
            <span>Total Karyawan Aktif: 4</span>
            <!--  -->
          </b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet">
          <b-row class="place-action">
            <b-col class="flex flex-col">
              <div class="action-item">tunda</div>
              <div class="action-item">mulai</div>
              <div class="action-item">selesai</div>
              <div class="action-item">perbaikan</div>
              <div class="action-item">ubah</div>
              <div class="action-item">penilaian</div>
              <!-- <b-row>
                <b-col>tunda</b-col>
              </b-row>
              <b-row>
                <b-col>mulai</b-col>
              </b-row>
              <b-row>
                <b-col>selesai</b-col>
              </b-row>
              <b-row>
                <b-col>perbaikan</b-col>
              </b-row>
              <b-row>
                <b-col>ubah</b-col>
              </b-row>
              <b-row>
                <b-col>penilaian</b-col>
              </b-row>-->
            </b-col>
          </b-row>
        </vue-bottom-sheet>
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
  overflow-y: scroll;
}
.place-item {
  border-bottom: 1px solid #dbdfea;
  padding: 0.5rem;
}
.place-action {
  padding: 10px;
}
.action-item {
  margin: 10px 0px 10px 0px;
}
</style>
