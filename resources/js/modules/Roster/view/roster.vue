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
        <br />
        <b-tabs content-class="mt-3">
          <b-tab title="Utama">
            <Main />
          </b-tab>
          <b-tab title="Status" active>
            <Status />
          </b-tab>
        </b-tabs>
      </div>
    </div>
  </div>
</template>

<script>
import Main from "./main";
import Status from "../../RosterStatus/rosterStatus";
export default {
  props: {
    user: String,
    baseUrl: String,
  },
  data() {
    return {
      title: "Roster",
      version: "v1.1",
    };
  },
  components: { Main, Status },
  mounted() {
    this.$store.commit("INSERT_BASE_URL", { base_url: this.baseUrl });
    this.$store.commit("INSERT_USER", { user: JSON.parse(this.user) });

    this.$store.commit("roster/INSERT_BASE_URL", {
      base_url: this.baseUrl,
    });
    this.$store.commit("rosterStatus/INSERT_BASE_URL", {
      base_url: this.baseUrl,
    });

    this.$store.dispatch("rosterStatus/fetchData");
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
