
function getSearchData() {
    let year = $("#year_search").val();
    let month = $("#month_search").val();
    return {
        year,
        month,
    };
}
async function loadBudget($filters = {}) {
    let { year=null, month=null } = $filters;
    let queryParams = new URLSearchParams();
    if(year)queryParams.append('year', year);
    if(month)queryParams.append('month', month);

    let needTableBody = $("#needTable tbody");
    let wantTableBody = $("#wantTable tbody");
    let savingsTableBody = $("#savingsTable tbody");
    // Loading message
    needTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    wantTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    savingsTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    let response = await fetch(`${BASE_URL}/api/budget?${queryParams.toString()}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });

    let result = await response.json();
    let budgets = result.data;
    renderBudgetTable(needTableBody, budgets.filter(b => b.expense_item.expense_type === 'Need'));
    renderBudgetTable(wantTableBody, budgets.filter(b => b.expense_item.expense_type === 'Want'));
    renderBudgetTable(savingsTableBody, budgets.filter(b => b.expense_item.expense_type === 'Savings'));
}
function renderBudgetTable(budgetPlanTableBody, budgetPlans) {
    if (budgetPlans.length === 0) {
        budgetPlanTableBody.html(
            `<tr><td class="text-center" colspan="100%">No data found.</td></tr>`
         );
        return;
    }

    let rows = "";
    let totalPlanAmount = 0;
    let totalExpenseAmount = 0;
    let totalRemainingAmount = 0;
    budgetPlans.forEach((plan, index) => {
        totalPlanAmount += parseFloat(plan.amount);
        totalExpenseAmount += parseFloat(plan.total_expense);
        totalRemainingAmount += parseFloat(plan.remaining_amount);
        let bgColor = "bg-primary";
        let textColor = "text-white";
        if(plan.remaining_amount == 0){
            bgColor = "";
            textColor = "text-dark";
        }else if(plan.remaining_amount < 0){
            bgColor = "bg-danger";
        }
        rows += `<tr class="align-middle ${bgColor} ">
            <td class="${textColor}">${plan.expense_item.expense_item}</td>
            <td class="${textColor}">${Number(plan.amount.toString().replace(/\.0+$/, "")).toLocaleString()}</td> 
            <td class="${textColor}">${Number(plan.total_expense.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
            <td class="${textColor} text-end">${Number((plan.remaining_amount).toString().replace(/\.0+$/, "")).toLocaleString()}</td>
            </tr>`;
    });
    // Append total row
    rows += `<tr class="fw-bold">
        <td>Total</td>
        <td>${Number(totalPlanAmount.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
        <td>${Number(totalExpenseAmount.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
        <td class="text-end">${Number(totalRemainingAmount.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
        </tr>`;
    budgetPlanTableBody.html(rows);
}


$(document).ready(function () {
   
    loadBudget(getSearchData());
    $("#searchButton").on("click", function (e) {
        e.preventDefault();
        loadBudget(getSearchData());
    });
});
