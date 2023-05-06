import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    employee_id: null,
    amount: null, // jumlah nominal kasbon
    amount_readable: null,
    reason: null,
}

const SalaryAdvance = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                name: "Muhammad Adi",
                position_name: "Welder",
                amount: "Rp. 1.500.000",
                monthly_deduction: "Rp. 500.000",
                duration: "3 Bulan",
                note: "catatan kecil",
            }
        ],
        params: {
            date_filter: new Date(),
            type: "belum lunas",
        },
        form: { ...defaultForm },
        options: {
            types: [
                {
                    id: "lunas",
                    name: "lunas",
                },
                {
                    id: "belum lunas",
                    name: "belum lunas",
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

                // console.info(readAble);

                state.form.amount = numericValue;
                state.form.amount_readable = readAble;

                // console.info(state);
            }
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default SalaryAdvance;
