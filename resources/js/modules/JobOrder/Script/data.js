import { checkNull, isMobile } from "../../../utils";
import FilterData from "../View/filter";
export default {
    data() {
        return {
            title: "",
        };
    },
    components: { FilterData },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
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
    methods: {
        onOpenAction(form) {
            //   console.info(id);
            this.$store.commit("jobOrder/INSERT_FORM", {
                form
            });

            this.$store.commit("employeeHasParent/UPDATE_IS_MOBILE", {
                value: true,
            });
            this.$bvModal.show("action_list");
        },
        onAction(type, title) {
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
            // this.$store.commit("jobOrder/CLEAR_FORM_ACTION");

            //   console.info(this.form);

            this.$bvModal.show("job_order_form_action");
        },
        onCreate() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Tambah Job Order",
                form_kind: "create",
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
            });
        },
        onDetail() {
            this.$store.commit("jobOrder/INSERT_FORM_KIND", {
                form_title: "Detail Job Order",
                form_kind: "detail",
            });
            this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
                value: true,
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
    },
};
