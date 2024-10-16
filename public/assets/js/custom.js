// toast.js
document.addEventListener("DOMContentLoaded", function () {
    // Initialize the SweetAlert2 Toast
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

    // Check for success message
    if (sessionStorage.getItem("success")) {
        Toast.fire({
            icon: "success",
            title: sessionStorage.getItem("success"),
        });
        sessionStorage.removeItem("success"); // Clear the message after showing
    }

    // Check for error message
    if (sessionStorage.getItem("error")) {
        Toast.fire({
            icon: "error",
            title: sessionStorage.getItem("error"),
        });
        sessionStorage.removeItem("error"); // Clear the message after showing
    }

    // Check for warning message
    if (sessionStorage.getItem("warning")) {
        Toast.fire({
            icon: "warning",
            title: sessionStorage.getItem("warning"),
        });
        sessionStorage.removeItem("warning"); // Clear the message after showing
    }
});