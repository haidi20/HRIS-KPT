import VueSelect from "vue-select";

export default {
    components: {
        VueSelect,
    },
    computed: {
        getOptionEmplyeeBases() {
            return this.$store.state.employeeHasParent.options.employee_bases;
        },
        getOptionEmployees() {
            return this.$store.state.employeeHasParent.data.options;
        },
        getOptionPositions() {
            return this.$store.state.master.data.positions;
        },
        getOptionJobOrders() {
            return this.$store.state.jobOrder.data.map((item) => ({
                ...item,
                name: item.project_name,
            }));
        },
        getData() {
            return this.$store.state.employeeHasParent.data.selecteds;
        },
        form() {
            return this.$store.state.employeeHasParent.form;
        },
    },
    methods: {
        onChoose() {
            if (this.form.employee_id == null || this.form.employee_id == "")
                return false;

            const checkData = this.getData.find(
                (item) => item.employee_id == this.form.employee_id
            );

            // jika sudah ada datanya tidak perlu di masukkan lagi
            if (!checkData) {
                const getEmployee = this.getOptionEmployees.find(
                    (item) => item.id == this.form.employee_id
                );

                //   console.info(getEmployee);
                this.$store.commit("employeeHasParent/INSERT_DATA_SELECTED", {
                    employee: {
                        employee_id: getEmployee.id,
                        employee_name: getEmployee.name,
                        position_name: getEmployee.position_name,
                    },
                });
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                console.info(checkData);

                Toast.fire({
                    icon: "warning",
                    title: `Maaf, karyawan atas nama ${checkData.employee_name} sudah dipilih`,
                });
            }
        },
    },
};
