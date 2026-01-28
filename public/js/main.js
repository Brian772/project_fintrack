function togglePasswordVisibility(btn) {
    const input = document.getElementById("password");
    const icon = btn.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

function closeSuccessModal() {
    const modal = document.getElementById("successModal");
    if (!modal) return;

    modal.classList.add("opacity-0");
    setTimeout(() => modal.remove(), 200);
}
setTimeout(() => {
    closeSuccessModal();
}, 2500);