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


document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("expenseChart");
    if (!ctx) return;

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: "Pemasukan",
                    data: chartIncomeData,
                    backgroundColor: "#10b981", // Green color for income
                    borderRadius: 6,
                    barThickness: 30,
                },
                {
                    label: "Pengeluaran",
                    data: chartExpenseData,
                    backgroundColor: "#f43f5e", // Red/Pink color for expenses
                    borderRadius: 6,
                    barThickness: 30,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => "Rp " + value.toLocaleString("id-ID"),
                    },
                    grid: {
                        color: '#f3f4f6'
                    }
                }
            }
        }
    });

    // Modal handlers
    const openModalBtn = document.getElementById("openModal");
    const closeModalBtn = document.getElementById("closeModal");
    const modal = document.getElementById("transactionModal");

    if (openModalBtn && closeModalBtn && modal) {
        openModalBtn.onclick = () => {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        };
        closeModalBtn.onclick = () => {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        };
        // Close modal when clicking outside
        modal.onclick = (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }
        };
    }
});