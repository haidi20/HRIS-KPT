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
          <b-col class="place-item">
            <b-row>
              <b-col cols>
                <h5>Welder</h5>
                <h6>Muhammad Adi</h6>
                <span>Aktif: Ya</span>
              </b-col>
              <b-col cols class="place-action">
                <b-button variant="warning" size="sm" @click="onPause(i)">Tunda</b-button>
                <b-button variant="success" size="sm" @click="onPause(i)">Aktifkan</b-button>
              </b-col>
            </b-row>
            <!-- <b-row>
              <b-col>
                <span>Masuk : 08:10</span>
              </b-col>
            </b-row>-->
            <!--  -->
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  methods: {
    onOpenAction(i) {
      console.info(i);
    },
    onPause(i) {
      console.info(`pause ${i}`);
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
.place-action {
  text-align: right;
  align-self: center;
}
</style>
