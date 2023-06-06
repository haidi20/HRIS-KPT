import VueSelect from "vue-select";
import axios from "axios";
import moment from "moment";

import EmployeeHasParent from "../../EmployeeHasParent/view/employeeHasParent";

import { imageToBase64 } from "../../../utils";

export default {
    data() {
        return {
            label_image: null,
            is_image: false,
            is_loading: false,
        };
    },
    mounted() {
        // this.$bvModal.show("data_employee");
    },
    components: {
        VueSelect,
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
            return this.$store.state.jobOrder.form_title;
        },
        getOptionProjects() {
            return this.$store.state.project.data;
        },
        getOptionCategories() {
            return this.$store.state.jobOrder.options.categories;
        },
        getOptionJobs() {
            return this.$store.state.master.data.jobs;
        },
        getOptionJobLevels() {
            return this.$store.state.jobOrder.options.job_levels;
        },
        getOptionTimeTypes() {
            return this.$store.state.jobOrder.options.time_types;
        },
        getEmployeeSelecteds() {
            return this.$store.state.employeeHasParent.data.selecteds;
        },
        getLabelImage() {
            return this.$store.state.jobOrder.form.label_image;
        },
        form() {
            return this.$store.state.jobOrder.form;
        },
        job_id: {
            get() {
                return this.$store.state.jobOrder.form.job_id;
            },
            set(value) {
                this.$store.commit("jobOrder/INSERT_FORM_JOB_ID", {
                    job_id: value,
                });
            },
        },
        hour_start: {
            get() {
                return this.$store.state.jobOrder.form.hour_start;
            },
            set(value) {
                this.$store.commit("jobOrder/INSERT_FORM_HOUR_START", {
                    hour_start: value,
                });
            },
        },
        estimation: {
            get() {
                return this.$store.state.jobOrder.form.estimation;
            },
            set(value) {
                this.$store.commit("jobOrder/INSERT_FORM_ESTIMATION", {
                    estimation: value,
                });
            },
        },
        time_type: {
            get() {
                return this.$store.state.jobOrder.form.time_type;
            },
            set(value) {
                this.$store.commit("jobOrder/INSERT_FORM_TIME_TYPE", {
                    time_type: value,
                });
            },
        },
    },
    watch: {
        job_id(value, oldMessage) {
            if (value != null) {
                const findJob = this.getOptionJobs.find(item => item.id == value);

                console.info(findJob);

                this.$store.commit("jobOrder/INSERT_FORM_JOB_CODE", {
                    job_code: findJob.code,
                });
            }
        },
        hour_start(value, oldMessage) {
            this.$store.commit("jobOrder/INSERT_FORM_DATETIME_ESTIMATION_END");
        },
        estimation(value, oldMessage) {
            this.$store.commit("jobOrder/INSERT_FORM_DATETIME_ESTIMATION_END");
        },
        time_type(value, oldMessage) {
            this.$store.commit("jobOrder/INSERT_FORM_DATETIME_ESTIMATION_END");
        },
    },
    methods: {
        onCloseModal() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Job Order",
                form_kind: null,
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: false,
            });
            this.$bvModal.hide("job_order_form");
        },
        onShowEmployee() {
            this.$bvModal.show("data_employee");
        },
        async onSend() {
            const Swal = this.$swal;

            let request = {
                ...this.form,
                employee_selecteds: [...this.getEmployeeSelecteds],
                user_id: this.getUserId,
            };

            if (this.form.image != null) {
                request.image = await imageToBase64(request.image);
            }

            console.info(request);
            // return false;
            this.is_loading = true;

            await axios
                .post(`${this.getBaseUrl}/api/v1/job-order/store`, request)
                .then((responses) => {
                    console.info(responses);
                    this.is_loading = false;
                    // return false;
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
                        this.$store.commit("jobOrder/CLEAR_FORM");
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
            const readOnly = this.$store.getters["jobOrder/getReadOnly"];
            //   console.info(readOnly);

            return readOnly;
        },
    },
};
