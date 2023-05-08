import axios from "axios";
import moment from "moment";

const defaultForm = {
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
            positions: [
                {
                    id: 1,
                    name: "Welder",
                }
            ],
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
        UPDATE_IS_FORM_MOBILE(state, payload) {
            state.is_form_mobile = payload.value;
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default Employee;
