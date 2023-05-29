import axios from "axios";
import moment from "moment";

const defaultForm = {
    // id: null,
    employee_id: null,
    position_id: null,
    job_order_id: null,
    employee_base: "all",
    form_type: "create",
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
            date_filter: new Date(),
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
        is_form_mobile: true,
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
                ...state.data.selecteds,
                { ...payload.employee, },
            ];
        },
        INSERT_DATA_ALL_SELECTED(state, payload) {
            // console.info(payload);
            state.data.selecteds = [...payload.selecteds];
        },
        INSERT_FORM(state, payload) {
            state.form = {
                ...state.form,
                ...payload.form,
                form_type: payload.form_type,
            };
        },
        INSERT_FORM_FORM_TYPE(state, payload) {
            state.form.form_type = payload.from_type;
        },
        UPDATE_IS_FORM_MOBILE(state, payload) {
            state.is_form_mobile = payload.value;
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

    }
}

export default EmployeeHasParent;
