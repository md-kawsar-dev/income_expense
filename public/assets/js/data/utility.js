 $(".datepicker_year_month")
        .datepicker({
            dateFormat: 'yyyy-mm',
            viewMode: "date",
            autoclose: !0,
            multidateSeparator: "/",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+100",
        })
        .on("keypress", function () {
            return false;
        }),
function canDelete() {
    return [1, 2].includes(roleId());
}
function canEdit() {
    return [1, 2, 3].includes(roleId());
}

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});
function Tost(message, icon = "success") {
    Toast.fire({
        icon: icon,
        title: message,
    });
}
// Toast.fire({
//   icon: "success",
//   title: "Signed in successfully"
// });
