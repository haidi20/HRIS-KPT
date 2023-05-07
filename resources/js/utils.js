export const cleaningNumber = (value) => value?.toString().replace(/\./g, "");

// export const numbersOnly = (value) => value.replace(/[^\d]/g, "");
export const numbersOnly = (value) => value.replace(/\./g, '').replace(',', '.');

// contoh formatCurrency(20000, ".");
/* Fungsi formatRupiah */
export const formatCurrency = (value, prefix) => {
    let separator = null;
    let number_string = value
        .toString()
        .replace(/[^,\d]/g, "")
        .toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    return prefix == undefined ? rupiah : rupiah ? rupiah : "";
};

export const convertMonthToRoman = (month) => {
    const romanNumerals = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    return romanNumerals[month];
}
