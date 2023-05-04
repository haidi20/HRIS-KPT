<template>
  <div>
    <b-modal
      id="job_order_filter"
      ref="job_order_filter"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col>
          <input type="text" placeholder="search..." style="width: 100%" class="form-control" />
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" size="sm" class="float-end" @click="onFilter()">Kirim</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      getTitleForm: "Filter Data",
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
