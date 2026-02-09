// Coffee Shop Admin - Main JavaScript

// Toast Notification System
function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">☕</div>
        <div class="toast-message">${message}</div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add("show"), 100);
    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Confirm Dialog
function confirmDelete(
    message = "Apakah Anda yakin ingin menghapus data ini?",
) {
    return confirm(message);
}

// Auto-hide alerts
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll("[required]");
    let isValid = true;

    inputs.forEach((input) => {
        if (!input.value.trim()) {
            input.classList.add("is-invalid");
            isValid = false;
        } else {
            input.classList.remove("is-invalid");
        }
    });

    return isValid;
}

// Number formatting
function formatCurrency(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
}

// Sidebar toggle for mobile
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".sidebar-overlay");

    if (sidebar && overlay) {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
    }
}

// Steam animation helper
function createSteamEffect(element) {
    for (let i = 0; i < 3; i++) {
        const steam = document.createElement("div");
        steam.className = "steam";
        steam.style.left = `${20 + i * 30}%`;
        steam.style.animationDelay = `${i * 0.5}s`;
        element.appendChild(steam);
    }
}

// Initialize tooltips
document.addEventListener("DOMContentLoaded", function () {
    const tooltips = document.querySelectorAll("[data-tooltip]");
    tooltips.forEach((el) => {
        el.addEventListener("mouseenter", function () {
            const tooltip = document.createElement("div");
            tooltip.className = "tooltip";
            tooltip.textContent = this.dataset.tooltip;
            this.appendChild(tooltip);
        });

        el.addEventListener("mouseleave", function () {
            const tooltip = this.querySelector(".tooltip");
            if (tooltip) tooltip.remove();
        });
    });
});

// Add fade-in animation to cards
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card");
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add("fade-in");
    });
});

// Search functionality
function searchTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    if (!input || !table) return;

    const filter = input.value.toUpperCase();
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        rows[i].style.display = found ? "" : "none";
    }
}
