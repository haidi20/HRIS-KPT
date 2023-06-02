import DatatableClient from "../../../components/DatatableClient";

export default {
    data() {
        return {
            columns: [
                {
                    label: "Nama Karyawan",
                    field: "employee_name",
                    width: "250px",
                    class: "",
                },
                {
                    label: "Nama Departemen",
                    field: "position_name",
                    width: "150px",
                    class: "",
                },
                {
                    label: "",
                    class: "",
                    width: "0px",
                },
            ],
            options: {
                perPage: 5,
                // perPageValues: [5, 10, 25, 50, 100],
            },
        };
    },
    components: {
        DatatableClient,
    },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
        },
        getData() {
            return this.$store.state.employeeHasParent.data.selecteds;
        },
        getIsMobile() {
            return this.$store.state.employeeHasParent.data.selecteds;
        },
        getForm() {
            return this.$store.state.employeeHasParent.form;
        },
        params() {
            return this.$store.state.employeeHasParent.params;
        },
        search() {
            return this.$store.state.employeeHasParent.params.search;
        },
    },
    methods: {
        onSearch() {
            console.info(this.search);
        },
        onDelete() {
            const index = this.getForm.data_index;

            // console.info(index);
            this.$store.commit("employeeHasParent/DELETE_DATA_SELECTED", { index });
            this.$bvModal.hide("action_list_employee");
        },
        onDeleteAll() {
            this.$store.commit("employeeHasParent/CLEAR_DATA_SELECTED");
        },
        onOpenAction(item, index) {
            // console.info(item);

            this.$store.commit("employeeHasParent/INSERT_FORM", { form: { ...item, data_index: index } });
            this.$bvModal.show("action_list_employee");
        },
        onAction(from_type, from_title) {
            this.$store.commit("employeeHasParent/INSERT_FORM_FORM_TYPE", { from_type });
        },
        getConditionActionActive() {
            let result = true;

            if (
                (
                    this.getForm.status == 'active'
                    || this.getForm.status == 'overtime'
                    || this.getForm.status == null
                )
                && this.getForm.form_type == 'create'
            ) {
                result = false;
            }

            // console.info(this.getForm.form_type);

            return result;
        },
        getConditionActionDelete() {
            let result = false;

            // hapus hanya ketika buat data, kalo edit hanya bisa pending
            if (this.getForm.form_type == 'create') {
                result = true;
            }

            // console.info(this.getForm.form_type);

            return result;
        },
        getColumns() {
            const columns = this.columns.filter((item) => item.label != "");
            return columns;
        },
    },
};
