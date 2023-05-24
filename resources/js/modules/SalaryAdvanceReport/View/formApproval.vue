<template>
  <div>
    <b-modal
      id="salary_advance_approval_form"
      ref="salary_advance_approval_form"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <template v-if="form.approval_status == 'accept'">
        <b-row>
          <b-col cols="6">
            <span>
              <b>Total Pinjaman</b> :
            </span>
            <br />
            <span>{{form.loan_amount_readable}}</span>
          </b-col>
          <b-col cols="6">
            <span>
              <b>Sisa Pinjaman</b> :
            </span>
            <br />
            <span>{{form.remaining_debt_readable}}</span>
          </b-col>
        </b-row>
        <br />
        <!-- <b-row>
          <b-col cols>
            <b-form-group label label-for="type" class>
              <VueSelect
                id="type"
                class="cursor-pointer"
                v-model="form.type"
                :options="getOptionTypes"
                :reduce="(data) => data.id"
                label="name"
                searchable
                style="min-width: 180px"
              />
            </b-form-group>
          </b-col>
        </b-row>-->
        <b-row v-if="form.type == 'nominal'">
          <b-col cols="6">
            <b-form-group label="Nominal Potongan Per Bulan" label-for="monthly_deduction" class>
              <b-form-input
                v-model="monthly_deduction"
                id="monthly_deduction"
                name="monthly_deduction"
                :disabled="getReadOnly()"
                autocomplete="off"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Potongan Setiap Bulan :" label-for="duration" class>
              <span>{{getDeductionFormula()}}</span>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row v-if="form.type == 'month'">
          <b-col cols="6">
            <b-form-group label="Lama Pembayaran (bulan)" label-for="duration" class>
              <b-form-input
                v-model="form.duration"
                id="duration"
                name="duration"
                :disabled="getReadOnly()"
                autocomplete="off"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Potongan Setiap Bulan :" label-for="duration" class>
              <span>{{getDeductionFormula()}}</span>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col cols="12">
            <b-form-group label="Catatan" label-for="note" class>
              <b-form-input
                v-model="form.note"
                id="note"
                name="note"
                :disabled="getReadOnly()"
                autocomplete="off"
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </template>
      <b-row v-if="form.approval_status == 'reject'">
        <b-col cols="12">
          <b-form-group label="Alasan Menolak" label-for="note" class>
            <b-form-input v-model="form.note" id="note" name="note" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            style="float: right"
            variant="success"
            @click="onSend()"
            :disabled="is_loading"
          >Simpan</b-button>
          <span v-if="is_loading" style="float: right">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script src="../Script/formApprovalScript.js"></script>

<style lang="scss" scoped>
</style>
