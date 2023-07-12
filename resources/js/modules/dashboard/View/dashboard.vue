<template>
  <div>
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last d-flex align-items-center">
            <h3 class="d-flex align-items-center">Dashboard</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content">
      <section class="row">
        <div class="col-12 col-lg-12">
          <div class="row">
            <div class="col-6 col-lg-3 col-md-6" v-for="(total, index) in list_total" :key="index">
              <div class="card">
                <div class="card-body py-3-5">
                  <div class="row">
                    <div class="col-md-4">
                      <div :class="`stats-icon ${total.color}`">
                        <i :class="total.icon"></i>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <h6 class="text-muted font-semibold">{{total.title}}</h6>
                      <h6 class="font-extrabold mb-0">{{total.value}}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-lg-4 col-md-12">
              <div class="card">
                <div class="card-body px-3 py-3-5">
                  <DatatableClient
                    :data="getDataEmployeeNotHaveJobOrder"
                    :columns="employee_notyet_columns"
                    :options="options"
                    nameStore="dashboard"
                    nameLoading="employee_not_have_job_order"
                    :filter="true"
                    :footer="false"
                    bordered
                  >
                    <template v-slot:filter>
                      <b-col cols>Karyawan Belum Punya Job Order</b-col>
                    </template>
                    <template v-slot:tbody="{ filteredData }">
                      <b-tr v-for="(item, index) in filteredData" :key="index">
                        <b-td
                          v-for="column in getColumns()"
                          :key="column.label"
                        >{{ item[column.field] }}</b-td>
                      </b-tr>
                    </template>
                  </DatatableClient>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-md-12">
              <div class="card">
                <div class="card-body px-3 py-3-5">
                  <DatatableClient
                    :data="getDataFiveEmployeeHighestJobOrder"
                    :columns="employee_columns"
                    :options="options"
                    nameStore="dashboard"
                    nameLoading="five_employee_highest_job_order"
                    :filter="true"
                    :footer="false"
                    bordered
                  >
                    <template v-slot:filter>
                      <b-col cols>5 Karyawan Dengan Job Order Terbanyak</b-col>
                    </template>
                    <template v-slot:tbody="{ filteredData }">
                      <b-tr v-for="(item, index) in filteredData" :key="index">
                        <b-td
                          v-for="column in getColumns()"
                          :key="column.label"
                        >{{ item[column.field] }}</b-td>
                      </b-tr>
                    </template>
                  </DatatableClient>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-md-12">
              <div class="card">
                <div class="card-body px-3 py-3-5">
                  <DatatableClient
                    :data="getDataPosition"
                    :columns="position_columns"
                    :options="options"
                    nameStore="dashboard"
                    nameLoading="position"
                    :filter="true"
                    :footer="false"
                    bordered
                  >
                    <template v-slot:filter>
                      <b-col cols>Total Karyawan Berdasarkan Jabatan</b-col>
                    </template>
                    <template v-slot:tbody="{ filteredData }">
                      <b-tr v-for="(item, index) in filteredData" :key="index">
                        <b-td
                          v-for="column in getColumns()"
                          :key="column.label"
                        >{{ item[column.field] }}</b-td>
                      </b-tr>
                    </template>
                  </DatatableClient>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script src="../Script/dashboard.js"></script>

<style lang="scss" scoped>
</style>
