<template>
  <div>
    <b-row>
      <b-col col md="12">
        <DatatableClient
          :data="getData"
          :columns="columns"
          :options="options"
          nameStore="employeeHasParent"
          nameLoading="table"
          :filter="true"
          :footer="false"
          bordered
        >
          <template v-slot:filter>
            <b-col cols>
              <b-button variant="danger" size="sm" @click="onDeleteAll()">Hapus Semua Data</b-button>
            </b-col>
          </template>
          <template v-slot:tbody="{ filteredData }">
            <b-tr v-for="(item, index) in filteredData" :key="index">
              <b-td v-for="column in getColumns()" :key="column.label">{{ item[column.field] }}</b-td>
              <b-td>
                <!-- <a href="#" @click="onDelete(item)" class="fomr-control">Hapus</a> -->
                <b-button variant="danger" size="sm" @click="onDelete(index)">Hapus</b-button>
              </b-td>
            </b-tr>
          </template>
        </DatatableClient>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import DatatableClient from "../../../components/DatatableClient";

export default {
  data() {
    return {
      columns: [
        {
          label: "Nama Karyawan",
          field: "employee_name",
          width: "250px",
          class: "",
        },
        {
          label: "Nama Departemen",
          field: "position_name",
          width: "150px",
          class: "",
        },
        {
          label: "",
          class: "",
          width: "0px",
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
      return this.$store.state.employeeHasParent.data.selecteds;
    },
  },
  methods: {
    onDelete(index) {
      this.$store.commit("employeeHasParent/DELETE_DATA_SELECTED", { index });
    },
    onDeleteAll() {
      this.$store.commit("employeeHasParent/CLEAR_DATA_SELECTED");
    },
    getColumns() {
      const columns = this.columns.filter((item) => item.label != "");
      return columns;
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
