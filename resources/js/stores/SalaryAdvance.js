import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const SalaryAdvance = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
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

    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default SalaryAdvance;
