import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import VueSelect from "vue-select";

import EmployeeHasParent from "../../EmployeeHasParent/view/employeeHasParent";

export default {
    data() {
        return {
            is_loading: false,
            getTitleForm: "Tambah Penyesuaian Gaji",
        };
    },
    components: {
        VueSelect,
        DatePicker,
        EmployeeHasParent,
    },
    mounted() {
        this.$store.commit("employeeHasParent/UPDATE_IS_FORM_MOBILE", {
            value: false,
        });
    },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
        },
        getOptionTypeTimes() {
            return this.$store.state.salaryAdjustment.options.type_times;
        },
        getOptionTypeAmount() {
            return this.$store.state.salaryAdjustment.options.type_amounts;
        },
        getOptionTypeAdjustments() {
            return this.$store.state.salaryAdjustment.options.type_adjustments;
        },
        getEmployeeForm() {
            return this.$store.state.employeeHasParent.form;
        },
        getEmployeeSelecteds() {
            return this.$store.state.employeeHasParent.data.selecteds;
        },
        form() {
            return this.$store.state.salaryAdjustment.form;
        },
        amount: {
            get() {
                return this.$store.state.salaryAdjustment.form.amount_readable;
            },
            set(value) {
                this.$store.commit("salaryAdjustment/INSERT_FORM_AMOUNT", {
                    amount: value,
                });
            },
        },
    },
    methods: {
        onCloseModal() {
            this.$bvModal.hide("salary_adjustment_form");
        },
        onChangeRangeMonth() {
            //
        },
        onActiveDateEnd() {
            //   this.is_date_end = !this.is_date_end;
            this.$store.commit("salaryAdjustment/UPDATE_FORM_IS_DATE_END", {
                value: !this.form.is_date_end,
            });
        },
        onShowEmployee() {
            this.$bvModal.show("data_employee");
        },
        onReplaceAmount($event) {
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;
            //   console.info(keyCode);

            //   this.amount = this.amount.replace(/[^\d.:]/g, "");
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 44) {
                // 46 is dot
                $event.preventDefault();
            }
        },
        async onSend() {
            const Swal = this.$swal;

            // mengambil data hexa saja
            const request = {
                ...this.form,
                position_id: this.getEmployeeForm.position_id,
                job_order_id: this.getEmployeeForm.job_order_id,
                employee_base: this.getEmployeeForm.employee_base,
                employee_selecteds: this.getEmployeeSelecteds,
                user_id: this.getUserId,
            };

            this.is_loading = true;

            console.info(request);

            await axios
                .post(`${this.getBaseUrl}/api/v1/salary-adjustment/store`, request)
                .then((responses) => {
                    console.info(responses);
                    this.is_loading = false;
                    const data = responses.data;

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

                    if (data.success == true) {
                        Toast.fire({
                            icon: "success",
                            title: data.message,
                        });

                        this.$bvModal.hide("salary_adjustment_form");
                        this.$store.dispatch("salaryAdjustment/fetchData");
                        this.$store.commit("salaryAdjustment/CLEAR_FORM");
                        this.$store.commit("employeeHasParent/CLEAR_FORM");
                        this.$store.commit("employeeHasParent/CLEAR_DATA_SELECTED");
                    }
                })
                .catch((err) => {
                    console.info(err);
                    this.is_loading = false;

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

                    Toast.fire({
                        icon: "error",
                        title: err.response.data.message,
                    });
                });
        },
        getReadOnly() {
            const readOnly = this.$store.getters["salaryAdjustment/getReadOnly"];
            //   console.info(readOnly);

            return readOnly;
        },
    },
};
