import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const example = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            //
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

export default example;
