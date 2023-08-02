<template>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-lg-0">
      <li class="nav-item dropdown me-3" v-if="is_show">
        <a
          class="nav-link active dropdown-toggle text-gray-600"
          href="#"
          data-bs-toggle="dropdown"
          data-bs-display="static"
          aria-expanded="false"
        >
          <i class="bi bi-bell bi-sub fs-4"></i>
          <span
            v-if="count_data > 0"
            class="badge bg-danger rounded-circle top-0 start-100 translate-middle"
            style="padding: 0.4rem 0.6rem!important;"
          >{{count_data}}</span>
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end notification-dropdown"
          aria-labelledby="dropdownMenuButton"
        >
          <li class="dropdown-header">
            <h6>Notifications</h6>
          </li>
          <!-- <li class="dropdown-item notification-item">
            <a class="d-flex align-items-center" href="#">
              <div class="notification-icon bg-success">
                <i class="bi bi-file-earmark-check"></i>
              </div>
              <div class="notification-text ms-4">
                <p class="notification-title font-bold">Job Order : PROJECT HQ</p>
                <p class="notification-subtitle font-thin text-sm">Tersisa 10 Menit Lagi</p>
              </div>
            </a>
          </li>-->
          <template v-if="data.length > 0">
            <li v-for="(item, index) in data" :key="index" class="dropdown-item notification-item">
              <a class="d-flex align-items-center" href="#">
                <div class="notification-icon bg-success">
                  <i class="bi bi-file-earmark-check"></i>
                </div>
                <div class="notification-text ms-4">
                  <p class="notification-title font-bold">Job Order : {{item.project_name}}</p>
                  <p class="notification-subtitle font-thin text-sm">Tersisa 10 Menit Lagi</p>
                  <p
                    class="notification-subtitle font-thin text-sm"
                  >{{item.datetime_estimation_end_readable}}</p>
                  <p
                    class="notification-subtitle font-thin text-sm"
                  >{{item.datetime_estimation_end_before}}</p>
                </div>
              </a>
            </li>
          </template>
          <template v-else>
            <div class="notification-text ms-4">
              <span>tidak ada notif</span>
            </div>
          </template>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
import io from "socket.io-client";

export default {
  props: {
    user_id: String,
  },
  data() {
    return {
      is_show: false,
      count_data: 0,
      data: [],
    };
  },
  mounted() {},
  created() {
    if (!this.is_show) return false;
    console.info(`userId = ${this.user_id}`);

    const timestamp = Date.now();
    const options = {
      //   autoConnect: false,
      //   query: `user_id=${this.user_id}`,
      query: {
        user_id: this.user_id,
        timestamp,
      },
    };

    this.socket = io.connect("http://localhost:3000", options); // replace with your server URL

    // listen to events from server
    this.socket.on("get-notification", (data) => {
      console.info(data);
      this.count_data = data.data.length;
      this.data = data.data;
      //   this.message = data;
    });
  },
  beforeDestroy() {
    // disconnect when component is unmounted
    this.socket.disconnect();
  },
};
</script>

<style lang="scss" scoped>
</style>
