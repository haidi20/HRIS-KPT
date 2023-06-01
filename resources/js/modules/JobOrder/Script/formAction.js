import axios from "axios";
import moment from "moment";

import EmployeeHasParent from "../../EmployeeHasParent/view/employeeHasParent";

export default {
    data() {
        return {
            is_loading: false,
        };
    },
    components: {
        EmployeeHasParent,
    },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
        },
        getTitleForm() {
            return this.$store.state.jobOrder.form.form_title;
        },
        getKindForm() {
            return this.$store.state.jobOrder.form.form_kind;
        },
        form() {
            return this.$store.state.jobOrder.form;
        },
    },
    methods: {
        onShowEmployee() {
            this.$bvModal.show("data_employee");
        },
        onCloseModal() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Job Order",
                form_kind: null,
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: false,
            });
        },
        async onSend() {
            const Swal = this.$swal;

            const request = {
                id: this.form.id,
                date: moment(this.form.date).format("YYYY-MM-DD"),
                hour: this.form.hour,
                status: this.form.status,
                status_last: this.form.status_last,
                status_finish: this.form.status_finish,
                status_note: this.form.status_note,
                user_id: this.getUserId,
            };

            console.info(request);
            // return false;
            this.is_loading = true;

            await axios
                .post(`${this.getBaseUrl}/api/v1/job-order/store-action`, request)
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

                        this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                            form_title: "Job Order",
                            form_kind: null,
                        });
                        this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                            value: false,
                        });
                        this.$store.dispatch("jobOrder/fetchData");
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
        getConditionDisableDate() {
            let result = false;
            const listStatus = ["overtime"];

            // console.info(this.form.status);

            if (listStatus.some((item) => item == this.form.status)) {
                result = true;
            }

            return result;
        },
        getLabelNote() {
            let result = "Catatan";

            if (this.getKindForm == 'assessment') {
                result = "Catatan Penilaian";
            }

            return result;
        },
    },
};
