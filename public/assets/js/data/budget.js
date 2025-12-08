async function loadExpenseItem() {
    try {
        let response = await fetch(`${BASE_URL}/api/expense-items`, {
            method: "GET",
            headers: {
                Authorization: "Bearer " + getAuthToken(),
                Accept: "application/json",
            },
        });

        let result = await response.json(); // Convert response → JSON
        let categories = result.data;

        let html = '<option value="">Select ExpenseItem</option>';
        categories.forEach((expense) => {
            html += `<option value="${expense.id}">${expense.expense_item} (${expense.expense_type})</option>`;
        });
       $("#expense_item_id_search").html(html);
        $("#expense_item_id_search").select2();
    } catch (error) {
        let html = '<option value="">Select ExpenseItem</option>';
        $("#expense_item_id_search").html(html);
        $("#expense_item_id_search").select2();
    }
}

async function loadBudgetPlan() {
    let budgetPlanTableBody = $("#budgetPlanTable tbody");

    // Loading message
    budgetPlanTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    let expense_item_id_search = $("#expense_item_id_search").val();
    let year_month_search = $("#year_month_search").val();
    let queryParams = new URLSearchParams();
    queryParams.append('year_month', year_month_search);
    if (expense_item_id_search) {
        queryParams.append('expense_item_id', expense_item_id_search);
    }
    let response = await fetch(`${BASE_URL}/api/budget-plan?${queryParams.toString()}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });

    let result = await response.json();
    let budgetPlans = result.data;
    console.log("dataShow:" + budgetPlans);

    budgetPlanTableBody.empty();

    if (budgetPlans.length === 0) {
        budgetPlanTableBody.html(
            `<tr><td class="text-center" colspan="100%">No data available</td></tr>`
        );
        return;
    }

    // Sort budgetPlans by expense_type according to custom order
    const expenseItemOrder = ["Need", "Want", "Savings"];
    budgetPlans.sort((a, b) => {
        return (
            expenseItemOrder.indexOf(a?.expense_item?.expense_type) -
            expenseItemOrder.indexOf(b?.expense_item?.expense_type)
        );
    });
    console.log(budgetPlans);

    let row = "";
    let totalAmount = 0;

    let currentExpenseItem = null;
    let expenseItemTotal = 0;

    budgetPlans.forEach((plan, index) => {
        totalAmount += parseFloat(plan.amount);
        // If expense_type changes, insert expense_type header row
        if (plan?.expense_item?.expense_type !== currentExpenseItem) {
            // Print total of previous expense_type
            if (currentExpenseItem !== null) {
                row += `<tr class="bg-secondary">
                            <th style="color:white;" colspan="2" class="text-end">${currentExpenseItem} Total</th>
                            <th style="color:white;">${expenseItemTotal
                                .toString()
                                .replace(/\.0+$/, "")}</th>
                            <th></th>
                        </tr>`;
            }

            // New expense_type header
            currentExpenseItem = plan?.expense_item?.expense_type;
            expenseItemTotal = 0; // reset expense_type total

            row += `<tr class="text-center">
                        <th style="font-weight:bold;" colspan="4">${currentExpenseItem}</th>
                    </tr>`;
        }

        expenseItemTotal += parseFloat(plan.amount);

        // Normal budget row
        row += `<tr>
            <td>${index + 1}</td>
            <td>${plan?.expense_item?.expense_item}</td>
            <td>${plan.amount.toString().replace(/\.0+$/, "")}</td>
            <td>
                ${
                    canEdit()
                        ? `<button class="btn btn-sm btn-primary edit-btn" data-id="${plan.id}">Edit</button>`
                        : ""
                }
                ${
                    canDelete()
                        ? `<button class="btn btn-sm btn-danger delete-btn delete_btn" data-id="${plan.id}">Delete</button>`
                        : ""
                }
            </td>
        </tr>`;
    });

    // Print total for last expense_type
    if (currentExpenseItem !== null) {
        row += `<tr class="bg-secondary" >
                    <th style="color:white;" colspan="2" class="text-end">${currentExpenseItem} Total</th>
                    <th style="color:white;">${expenseItemTotal
                        .toString()
                        .replace(/\.0+$/, "")}</th>
                    <th></th>
                </tr>`;
    }

    // Grand total
    row += `<tr>
        <th colspan="2" class="text-end">Grand Total</th>
        <th>${totalAmount.toString().replace(/\.0+$/, "")}</th>
        <th></th>
    </tr>`;

    budgetPlanTableBody.html(row);
}

async function editBudgetPlan(id) {
    // Implement edit functionality if needed
    let response = await fetch(`${BASE_URL}/api/budget-plan/${id}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });
    let result = await response.json();
    let budgetPlan = result.data;
    $("#year_month").val(
        budgetPlan.year + "-" + String(budgetPlan.month).padStart(2, "0")
    );
    $("#expense_item_id").val(budgetPlan.expense_item_id).trigger("change");
    $("#amount").val(budgetPlan.amount.toString().replace(/\.0+$/, ""));
    $("#store_id").val(budgetPlan.id);
    $(".add_update_text").text("Update");
}
async function deleteBudgetPlan(id) {
    // Implement edit functionality if needed
    let response = await fetch(`${BASE_URL}/api/budget-plan/${id}`, {
        method: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });
    if (!response.ok) {
        Tost("Failed to delete budget plan.", "error");
        return;
    }
    Tost("Budget plan deleted successfully!");
    loadBudgetPlan();
}

$(document).ready(function () {
    if (!canEdit()) {
        $(".is_see").hide();
    }
    loadExpenseItem();
    $("#searchButton").on("click", function (e) {
        e.preventDefault();
        loadBudgetPlan();
    });
});
