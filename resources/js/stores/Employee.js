import axios from "axios";
import moment from "moment";

const defaultForm = {
    id: null,
    employee_id: null,
    data_base: "all",
}

const Employee = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            options: [
                {
                    id: 1,
                    name: "Muhammad Adi",
                }
            ],
            table: [
                {
                    id: 1,
                    name: "Muhammad Adi",
                    position_name: "Welder",
                }
            ],
            positions: [],
        },
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            data_bases: [
                {
                    id: 'all',
                    name: "Semua Karyawan",
                },
                {
                    id: 'employee',
                    name: "Karyawan",
                },
                {
                    id: 'position',
                    name: "Departemen",
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
            state.data.options = payload.data;
        },
        INSERT_DATA_TABLE(state, payload) {
            state.data.table = payload.data;
        },
        INSERT_DATA_POSITION(state, payload) {
            state.data.positions = payload.data;
        },
        INSERT_FORM(state, payload) {
            state.form = { ...state.form, ...payload.form };
        },
        UPDATE_IS_FORM_MOBILE(state, payload) {
            state.is_form_mobile = payload.value;
        },
    },
    actions: {
        fetchPosition: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/position/fetch-data`, {
                    params: {},
                }
                )
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    data.data = [
                        { id: "all", name: "Semua" },
                        ...data.data,
                    ];

                    context.commit("INSERT_DATA_POSITION", {
                        data: data.data,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },

    }
}

export default Employee;
