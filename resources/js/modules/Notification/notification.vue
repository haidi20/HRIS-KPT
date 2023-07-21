<template>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-lg-0">
      <li class="nav-item dropdown me-3">
        <a
          class="nav-link active dropdown-toggle text-gray-600"
          href="#"
          data-bs-toggle="dropdown"
          data-bs-display="static"
          aria-expanded="false"
        >
          <i class="bi bi-bell bi-sub fs-4"></i>
          <span
            class="badge bg-danger rounded-circle top-0 start-100 translate-middle"
            style="padding: 0.4rem 0.6rem!important;"
          >10</span>
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end notification-dropdown"
          aria-labelledby="dropdownMenuButton"
        >
          <li class="dropdown-header">
            <h6>Notifications</h6>
          </li>
          <li class="dropdown-item notification-item">
            <a class="d-flex align-items-center" href="#">
              <div class="notification-icon bg-success">
                <i class="bi bi-file-earmark-check"></i>
              </div>
              <div class="notification-text ms-4">
                <p class="notification-title font-bold">Job Order : PROJECT HQ</p>
                <p class="notification-subtitle font-thin text-sm">Tersisa 10 Menit Lagi</p>
              </div>
            </a>
          </li>
          <!-- <li>
            <p class="text-center py-2 mb-0">
              <a href="#">See all notification</a>
            </p>
          </li>-->
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
</style>
