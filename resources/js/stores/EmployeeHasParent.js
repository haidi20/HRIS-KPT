import axios from "axios";
import moment from "moment";

const defaultForm = {
    // id: null,
    employee_id: null,
    position_id: null,
    job_order_id: null,
    employee_base: "all",
    form_type: "create",
    form_type_parent: "create",
    // start job order
    data_index: null, // untuk hapus data yang sudah di pilih
    status: null,
}

const EmployeeHasParent = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            options: [],
            table: [],
            selecteds: [],
            foremans: [],
        },
        params: {
            search: null,
            date: new Date(),
        },
        form: { ...defaultForm },
        options: {
            employee_bases: [
                {
                    id: 'all',
                    name: "Semua Karyawan",
                },
                {
                    id: 'choose_employee',
                    name: "Pilih Karyawan",
                },
                {
                    id: 'position',
                    name: "Jabatan",
                },
                {
                    id: 'job_order',
                    name: "Job Order",
                },
                // {
                //     id: 'project',
                //     name: "Proyek",
                // },
            ],
        },
        loading: {
            table: false,
        },
        is_mobile: false,
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA_OPTION(state, payload) {
            state.data.options = payload.employees;
        },
        INSERT_DATA_TABLE(state, payload) {
            state.data.table = payload.employees;
        },
        INSERT_DATA_FOREMAN(state, payload) {
            state.data.foremans = payload.foremans;
        },
        INSERT_DATA_SELECTED(state, payload) {
            state.data.selecteds = [
                { ...payload.employee, },
                ...state.data.selecteds,
            ];
        },
        INSERT_DATA_ALL_SELECTED(state, payload) {
            console.info(payload);
            state.data.selecteds = [...payload.selecteds];
        },
        INSERT_FORM(state, payload) {
            state.form = {
                ...state.form,
                ...payload.form,
            };

            if (payload.form_type != null) {
                // form_type: payload.form_type,
                state.form.form_type = payload.form_type;
            }
        },
        INSERT_FORM_FORM_TYPE(state, payload) {
            state.form.form_type = payload.form_type;
            state.form.form_type_parent = payload.form_type_parent;
        },
        UPDATE_IS_MOBILE(state, payload) {
            state.is_mobile = payload.value;
        },
        DELETE_FORM_EMPLOYEE_ID(state, payload) {
            state.form.employee_id = null;
        },
        DELETE_DATA_SELECTED(state, payload) {
            state.data.selecteds.splice(payload.index, 1);
        },
        CLEAR_FORM(state, payload) {
            state.form = { ...defaultForm };
        },
        CLEAR_DATA_SELECTED(state, payload) {
            state.data.selecteds = [];
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-data`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_TABLE", {
                        employees: data.employees,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },
        fetchOption: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-option`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_OPTION", {
                        employees: data.employees,
                    });

                })
                .catch((err) => {
                    console.info(err);
                });
        },
        fetchForeman: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-foreman`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_FOREMAN", {
                        foremans: data.foremans,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },
    },
    getters: {
        getReadOnly: (state) => {
            let result = false;

            // console.info(state.form.form_type);

            if (state.form.form_type == "read") {
                result = true;
            }

            return result;
        },
    },
}

export default EmployeeHasParent;
