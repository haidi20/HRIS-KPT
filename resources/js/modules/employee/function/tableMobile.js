export default {
    methods: {
        onOpenAction(i) {
            this.$refs.myBottomSheetEmployee.open();
        },
        onPause(i) {
            console.info(`pause ${i}`);
        },
    },
};
