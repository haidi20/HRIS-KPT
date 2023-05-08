<template>
  <div>
    <b-row>
      <b-col col md="12">
        <DatatableClient
          :data="getData"
          :columns="columns"
          :options="options"
          nameStore="employee"
          nameLoading="table"
          :filter="false"
          :footer="true"
          bordered
        >
          <template v-slot:tbody="{ filteredData }">
            <b-tr v-for="(item, index) in filteredData" :key="index">
              <b-td>{{ item.name }}</b-td>
              <b-td>{{ item.postion_name }}</b-td>
              <b-td>
                <!-- <a href="#" @click="onDelete(item)" class="fomr-control">Hapus</a> -->
                <b-button variant="danger" size="sm" @click="onDelete()">Hapus</b-button>
              </b-td>
            </b-tr>
          </template>
        </DatatableClient>
      </b-col>
    </b-row>
  </div>
</template>

<script src="../function/tableDesktop.js"></script>

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
