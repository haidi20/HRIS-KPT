import { checkNull, isMobile } from "../../../utils";
import FilterData from "../View/filter";
import EmployeeHasParent from "../../EmployeeHasParent/view/employeeHasParent";
import { stubArray } from "lodash";

export default {
    data() {
        return {
            isChecked: true,
            title: "",
        };
    },
    components: { FilterData, EmployeeHasParent },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
        },
        getUserGroupName() {
            return this.$store.state.user?.group_name;
        },
        getData() {
            return this.$store.state.jobOrder.data;
        },
        getLoadingData() {
            return this.$store.state.jobOrder.loading.data;
        },
        getFormStatus() {
            return this.$store.state.jobOrder.form.status;
        },
        getIsMobile() {
            return isMobile();
        },
        getForm() {
            return this.$store.state.jobOrder.form;
        },
    },
    watch: {
        getBaseUrl(value) {
            if (value != null) {
                this.$store.dispatch("jobOrder/fetchData", { user_id: this.getUserId });
            }
        },
        getUserGroupName(value) {
            if (value != null) {
                if (value == 'Quality Control') {
                    this.$store.commit("jobOrder/INSERT_PARAM_CREATED_BY", { created_by: 'another_foreman' });
                }
            }
        }
    },
    methods: {
        onOpenAction(form) {
            //   console.info(id);
            this.$store.commit("jobOrder/INSERT_FORM", {
                form
            });

            this.$store.commit("employeeHasParent/UPDATE_IS_MOBILE", {
                value: true,
            });
            this.$store.commit("employeeHasParent/INSERT_DATA_ALL_SELECTED", {
                selecteds: [
                    ...form.job_order_has_employees,
                ],
            });
            this.$bvModal.show("action_list");
        },
        onShowEmployee() {
            let status = null;

            if (this.getUserId == this.getForm.created_by) {
                if (this.getFormStatus == 'overtime') {
                    status = 'read';
                }
                // else {
                //     status = "edit";
                // }
                // } else {
                //     status = "read";
            }

            // console.info(status);

            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", {
                form_type: status,
                form_type_parent: status,
            });
            this.$bvModal.show("data_employee");
            this.$bvModal.hide("action_list");
        },
        onAction(type, title) {
            this.$bvModal.hide("action_list");
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Job Order - " + title,
                form_kind: type,
            });
            // this.$store.commit("jobOrder/INSERT_FORM_STATUS", {
            //     status: type,
            // });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
            this.$store.commit("jobOrder/CLEAR_FORM_ACTION");
            this.$store.commit("jobOrder/INSERT_FORM_STATUS", { status: type });
            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", {
                form_type: "read",
                form_type_parent: "overtime",
            });
            this.$store.dispatch("employeeHasParent/onUpdateStatusDataSelected", { form_type: type });

            if (type == 'overtime') {
                this.$store.commit("employeeHasParent/UPDATE_DATA_ALL_SELECTED_STATUS_OVERTIME");
            }

            //   console.info(this.form);
        },
        onActionAssessment(type, title) {
            this.$bvModal.hide("action_list");
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Job Order - " + title,
                form_kind: type,
            });
            this.$store.commit("jobOrder/INSERT_FORM_STATUS", {
                status: type,
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
            this.$store.commit("jobOrder/CLEAR_FORM_ACTION");
            this.$store.dispatch("employeeHasParent/onUpdateStatusDataSelected", { form_type: type });

            //   console.info(this.form);

            this.$bvModal.show("job_order_form_action");
        },
        onCreate() {
            this.$store.commit("jobOrder/CLEAR_FORM");
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Tambah Job Order",
                form_kind: "create",
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
            this.$store.commit("employeeHasParent/CLEAR_DATA_SELECTED");
            this.$store.commit("employeeHasParent/UPDATE_IS_MOBILE", {
                value: true,
            });
            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", {
                form_type: "create",
                form_type_parent: "create",
            });
        },
        onRead() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Lihat Job Order",
                form_kind: "read",
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", {
                form_type: "read",
                form_type_parent: "read",
            });
            this.$bvModal.hide("action_list");
        },
        onEdit() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Ubah Job Order",
                form_kind: "edit",
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", {
                form_type: "edit",
                form_type_parent: "edit",
            });
            this.$bvModal.hide("action_list");
        },
        onFilter() {
            this.$bvModal.show("job_order_filter");
        },
        onLimitSentence(sentence) {
            const maxLength = 35;

            // console.info(sentence);

            if (checkNull(sentence) != null) {
                if (sentence.length > maxLength) {
                    sentence = sentence.substring(0, maxLength) + "...";
                }

                return sentence;
            }
        },
        getConditionActionActive() {
            let result = false;
            const listStatus = ["pending"];

            if (this.getFormStatus != null) {
                if (listStatus.some(item => item == this.getFormStatus)) {
                    result = true;
                }
            }

            return result;
        },
        getConditionPending() {
            let result = false;

            if (
                this.getFormStatus == 'active'
                && this.getForm.created_by == this.getUserId
            ) {
                result = true;
            }

            return result;
        },
        getConditionEdit() {
            let result = false;
            const listStatus = ['finish'];

            // console.info(this.getFormStatus);

            if (
                this.getFormStatus != 'finish'
                && this.getForm.created_by == this.getUserId
            ) {
                result = true;
            }

            return result;
        },
        getCan(permissionName) {
            const getPermission = this.$store.getters["getCan"](permissionName);

            return getPermission;
        },
    },
};
