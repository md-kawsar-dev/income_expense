


$(document).ready(function() {
    loadDashboardData();
});

async function loadDashboardData() {
    document.querySelector('.total_income_balance').innerText = formatCurrency(0);
    document.querySelector('.total_expense_balance').innerText = formatCurrency(0);
    document.querySelector('.total_balance').innerText = formatCurrency(0);
    document.querySelector('.total_savings_balance').innerText = formatCurrency(0);
    let response = await fetch(`${BASE_URL}/api/dashboard/summary`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });

    const { total_income, total_expense, total_balance, total_savings } = await response.json();
    document.querySelector('.total_income_balance').innerText = formatCurrency(total_income);
    document.querySelector('.total_expense_balance').innerText = formatCurrency(total_expense);
    document.querySelector('.total_balance').innerText = formatCurrency(total_balance);
    document.querySelector('.total_savings_balance').innerText = formatCurrency(total_savings);

}
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'BDT',
        minimumFractionDigits: 2
    }).format(amount);
}