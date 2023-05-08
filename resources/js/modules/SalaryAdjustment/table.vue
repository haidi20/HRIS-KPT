<template>
  <div>
    <DatatableClient
      :data="getData"
      :columns="columns"
      :options="options"
      nameStore="salaryAdjustment"
      nameLoading="table"
      :filter="false"
      :footer="false"
      bordered
    >
      <template v-slot:tbody="{ filteredData }">
        <b-tr v-for="(item, index) in filteredData" :key="index">
          <b-td>{{ item.name }}</b-td>
          <b-td>{{ item.time }}</b-td>
          <b-td>{{ item.amount }}</b-td>
          <b-td>{{ item.type_adjustment_name }}</b-td>
          <b-td>{{ item.note }}</b-td>
          <b-td>
            <!-- <a href="#" @click="onDelete(item)" class="fomr-control">Hapus</a> -->
            <b-button variant="primary" size="sm" @click="onDetail(item.id)">Detail</b-button>
            <b-button variant="info" size="sm" @click="onEdit(item.id)">Ubah</b-button>
            <b-button variant="danger" size="sm" @click="onDelete(item.id)">Hapus</b-button>
          </b-td>
        </b-tr>
      </template>
    </DatatableClient>
  </div>
</template>

<script>
import DatatableClient from "../../components/DatatableClient";

export default {
  data() {
    return {
      columns: [
        {
          label: "Nama",
          field: "name",
          width: "100px",
          class: "",
        },
        {
          label: "Waktu",
          field: "time",
          width: "100px",
          class: "",
        },
        {
          label: "Nilai",
          field: "amount",
          width: "100px",
          class: "",
        },
        {
          label: "Jenis",
          field: "type_adjustment_name",
          width: "100px",
          class: "",
        },
        {
          label: "Keterangan",
          field: "note",
          width: "100px",
          class: "",
        },
        {
          label: "",
          class: "",
          width: "20px",
        },
      ],
      options: {
        perPage: 5,
        // perPageValues: [5, 10, 25, 50, 100],
      },
    };
  },
  components: {
    DatatableClient,
  },
  computed: {
    getData() {
      return this.$store.state.salaryAdjustment.data;
    },
  },
  methods: {
    onDetail(id) {
      this.$bvModal.show("salary_adjustment_form");
    },
    onEdit(id) {
      this.$bvModal.show("salary_adjustment_form");
    },
    onDelete(id) {
      //
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
