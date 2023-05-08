import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    name: null,
    type_time: "base time",
    type_amount: "nominal",
    amount: null,
    amount_readable: null,
    date_start: new Date(),
    date_end: new Date(moment().add({ month: 1 })),
    type_adjustment: "deduction",
    note: null,
}

const SalaryAdjustment = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            type_times: [
                {
                    id: "forever",
                    name: "selamanya",
                },
                {
                    id: "base time",
                    name: "berdasarkan bulan",
                }
            ],
            // jenis jumlah dalam bentuk persen atau angka
            type_amounts: [
                {
                    id: "nominal",
                    name: "jumlah uang",
                },
                {
                    id: "percent",
                    name: "presentase dari gaji karyawan",
                },
            ],
            type_adjustments: [
                {
                    id: "deduction",
                    name: "pengurangan",
                },
                {
                    id: "addition",
                    name: "penambahan",
                },
            ],
        },
        loading: {
            table: false,
        },
    },
    mutations: {
        INSERT_FORM_AMOUNT(state, payload) {
            if (payload.amount != null) {
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(payload.amount.toString());
                const readAble = formatCurrency(payload.amount, ".");

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.amount = numericValue;
                state.form.amount_readable = readAble;

                console.info(state);
            }
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default SalaryAdjustment;
