
function canDelete() {
    return [1, 2].includes(roleId());
}
function canEdit() {
    return [1, 2, 3].includes(roleId());
}

let Toast = Swal.mixin({
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
