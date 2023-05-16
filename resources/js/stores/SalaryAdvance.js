import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    employee_id: null,
    loan_amount: null, // jumlah nominal kasbon
    loan_amount_readable: null,
    reason: null,
}

const SalaryAdvance = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            month: new Date(),
            type: "all",
            search: "",
            is_filter_month: true,
        },
        form: { ...defaultForm },
        options: {
            types: [
                // (opsional)
                // {
                //     id: "settled",
                //     name: "lunas",
                // },
                // {
                //     id: "unpaid",
                //     name: "belum lunas",
                // },
                {
                    id: "all",
                    name: "semua",
                },
                {
                    id: "review",
                    name: "menunggu persetujuan",
                },
                {
                    id: "reject",
                    name: "ditolak",
                },
                {
                    id: "accept",
                    name: "diterima",
                },
            ],
        },
        loading: {
            table: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.salaryAdvances;
        },
        INSERT_FORM_LOAN_AMOUNT(state, payload) {
            if (payload.loan_amount != null) {
                // console.info(typeof payload.loan_amount);
                const numericValue = numbersOnly(payload.loan_amount.toString());
                const readAble = formatCurrency(payload.loan_amount, ".");

                // console.info(readAble);

                state.form.loan_amount = numericValue;
                state.form.loan_amount_readable = readAble;

                // console.info(state);
            }
        },
        INSERT_PARAM_TYPE(state, payload) {
            state.params.type = payload.type;
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/salary-advance/fetch-data`, {
                    params: {
                        user_id: payload.user_id,
                    },
                }
                )
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        salaryAdvances: data.salaryAdvances,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },
    }
}

export default SalaryAdvance;

// {
//     id: 1,
//         name: "Muhammad Adi",
//             position_name: "Welder",
//                 loan_amount: "Rp. 1.500.000",
//                     monthly_deduction: "Rp. 500.000",
//                         duration: "3 Bulan",
//                             status: "accept",
//                                 status_readable: "Diterima",
//                                     note: "kebutuhan beli kompor baru, kompor lama rusak",
//             }
