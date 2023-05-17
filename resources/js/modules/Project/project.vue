<template>
  <div>
    <title>Roster</title>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <b-row>
          <b-col class="place-title">
            <h2>{{ title }}</h2>
            <p class="version">{{ version }}</p>
          </b-col>
        </b-row>
        <b-row>
          <b-col>filter data</b-col>
        </b-row>
        <br />
        <Table />
        <Form />
      </div>
    </div>
  </div>
</template>

<script>
import Table from "./table";
import Form from "./form";

export default {
  data() {
    return {
      title: "Proyek",
      version: "v1.1",
    };
  },
  components: {
    Table,
    Form,
  },
};
</script>

<style lang="css" scoped>
.version {
  font-size: 13px;
  margin-left: 5px;
}
.place-title {
  display: -webkit-inline-box;
}
</style>
