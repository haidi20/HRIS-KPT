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
        <template v-if="getData.length > 0">
          <b-row v-for="(item, index) in getData" :key="index" @click="onOpenAction(i)">
            <b-col class="place-item">
              <b-row>
                <b-col cols>
                  <h5>{{item.position_name}}</h5>
                  <h6>{{item.name}}</h6>
                  <span>Aktif: {{item.is_active}}</span>
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
        </template>
        <template v-else>
          <b-row>
            <b-col class="place-item">Data Kosong.</b-col>
          </b-row>
        </template>
      </b-col>
    </b-row>
    <vue-bottom-sheet ref="myBottomSheetEmployee">
      <div class="flex flex-col">
        <div class="action-item">mulai</div>
        <div class="action-item">tunda</div>
        <div class="action-item">selesai</div>
        <div class="action-item">lembur</div>
        <div class="action-item">selesai lembur</div>
        <div class="action-item">hapus</div>
      </div>
    </vue-bottom-sheet>
  </div>
</template>

<script >
export default {
  data() {
    return {
      is_loading: false,
    };
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.employeeHasParent.data.table;
    },
  },
  methods: {
    onOpenAction(data) {
      //   console.info(id);
      this.$refs.myBottomSheetEmployee.open();
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
.action-item {
  padding: 25px 0px 25px 20px;
  border-bottom: 1px solid #dbdfea;
}
</style>
