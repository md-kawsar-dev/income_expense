async function loadAddExpenseItem() {
    let date = $("#date").val();
    let queryParams = new URLSearchParams();
    if (date) {
        queryParams.append("year_month", date);
    }
    try {
        let response = await fetch(
            `${BASE_URL}/api/budget-plan?${queryParams.toString()}`,
            {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    Accept: "application/json",
                },
            }
        );

        let result = await response.json(); // Convert response → JSON
        let categories = result.data;

        let html = '<option value="">Select ExpenseItem</option>';
        categories.forEach((expense) => {
            html += `<option value="${expense.expense_item.id}">${expense.expense_item.expense_item} (${expense.expense_item.expense_type})</option>`;
        });
        $("#expense_item_id").html(html);
        $("#expense_item_id").select2();
    } catch (error) {
        let html = '<option value="">Select ExpenseItem</option>';
        $("#expense_item_id").html(html);
        $("#expense_item_id").select2();
    }
}
async function loadSearchExpenseItem() {
    let year = $("#year_search").val();
    let month = $("#month_search").val();
    let date = year && month ? `${year}-${String(month).padStart(2, "0")}` : null;
    let queryParams = new URLSearchParams();
    if (date) {
        queryParams.append("year_month", date);
    }
    try {
        let response = await fetch(
            `${BASE_URL}/api/budget-plan?${queryParams.toString()}`,
            {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    Accept: "application/json",
                },
            }
        );

        let result = await response.json(); // Convert response → JSON
        let categories = result.data;

        let html = '<option value="">Select ExpenseItem</option>';
        categories.forEach((expense) => {
            html += `<option value="${expense.expense_item.id}">${expense.expense_item.expense_item} (${expense.expense_item.expense_type})</option>`;
        });
        $("#expense_item_id_search").html(html);
        $("#expense_item_id_search").select2();
    } catch (error) {
        let html = '<option value="">Select ExpenseItem</option>';
        $("#expense_item_id_search").html(html);
        $("#expense_item_id_search").select2();
    }
}

async function loadExpenseList(year=null,month=null,date = null, expense_item_id = null) {
    let expenseTableBody = $("#expenseTable tbody");

    // Loading message
    expenseTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    let queryParams = new URLSearchParams();
    if (date) {
        queryParams.append("date", date);
    }
    if (year) {
        queryParams.append("year", year);
    }
    if (month) {
        queryParams.append("month", month);
    }
    if (expense_item_id) {
        queryParams.append("expense_item_id", expense_item_id);
    }
    let response = await fetch(
        `${BASE_URL}/api/expense?${queryParams.toString()}`,
        {
            method: "GET",
            headers: {
                Authorization: "Bearer " + getAuthToken(),
                Accept: "application/json",
            },
        }
    );

    let result = await response.json();
    let expenses = result.data;
    expenseTableBody.empty();
    let row = "";
    if (expenses.length === 0) {
        row = `<tr><td class="text-center" colspan="100%">No data available</td></tr>`;
    }
    
    expenses.forEach((expense, index) => {
        row += `<tr>
            <td>${index + 1}</td>
            <td>${expense.date}</td>
            <td>${expense.expense_item.expense_item} (${expense.expense_item.expense_type})</td>
            <td>${expense.amount}</td>
            <td>
            
            </td>
        </tr>`;
    });
    expenseTableBody.html(row);
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
function getInputData() {
    let date = $("#date").val();
    let expense_item_id = $("#expense_item_id").val();
    let amount = $("#amount").val();
    let description = $("#description").val();
    return {
        date: date,
        expense_item_id: expense_item_id,
        amount: amount,
        description: description,
    };
}
function clearForm() {
    $("#date").val("");
    $("#expense_item_id").val("").trigger("change");
    $("#amount").val("");
    $("#description").val("");
    $("#store_id").val("");
    $(".add_update_text").text("Add");
}
function storeExpense() {
    let data = getInputData();
    $.ajax({
        url: `${BASE_URL}/api/expense`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
        data: data,
        success: function (response) {
            clearForm();
            Tost("Expense saved successfully!");
            loadExpenseList();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    errors[field].forEach((msg) => {
                        Tost(msg, "error");
                    });
                }
            } else {
                Tost("Failed to save expense.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateExpense() {
    let id = $("#store_id").val();
    let data = getInputData();
    $.ajax({
        url: `${BASE_URL}/api/budget-plan/${id}`,
        type: "PUT",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
        data: data,
        success: function (response) {
            clearForm();
            Tost("Budget plan updated successfully!");
            $(".add_update_text").text("Add");
            $("#store_id").val("");
            loadBudgetPlan();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    errors[field].forEach((msg) => {
                        Tost(msg, "error");
                    });
                }
            } else {
                Tost("Failed to update budget plan.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
$(document).ready(function () {
    if (!canEdit()) {
        $(".is_see").hide();
    }
    $("#searchButton").on("click", function (e) {
        e.preventDefault();
        let year = $("#year_search").val();
        let month = $("#month_search").val();
        let date_search = $("#date_search").val();
        let expense_item_id = $("#expense_item_id_search").val();

        loadExpenseList(year, month, date_search, expense_item_id);
    });
    $("#refreshButton").on("click", function (e) {
        e.preventDefault();
        loadExpenseList();
    });
    $("#date").on("change click", function () {
        if($(this).val()){
            loadAddExpenseItem();
        }
    });
    $("#year_search, #month_search").on("change", function () {
        if($("#year_search").val() && $("#month_search").val()){
            loadSearchExpenseItem();
        }
    });
    loadAddExpenseItem();
    loadSearchExpenseItem();
    loadExpenseList();
   
    $("#submitButton").on("click", function (e) {
        e.preventDefault();
        let store_id = $("#store_id").val();
        if (store_id) {
            // update
            updateExpense();
        } else {
            // new
            storeExpense();
        }
    });
    loadBudgetPlan();
    $("#budgetPlanTable")
        .on("click", ".edit-btn", function () {
            let id = $(this).data("id");
            // Implement edit functionality if needed
            editBudgetPlan(id);
        })
        .on("click", ".delete_btn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteBudgetPlan(id);
                }
            });
        });

    $("#addPreviousMonthPlan").on("click", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "This will add budget plans from the previous month. Existing plans for the current month will not be affected.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${BASE_URL}/api/budget-plan/add/previous-month`,
                    type: "POST",
                    headers: {
                        Authorization: "Bearer " + getAuthToken(),
                        Accept: "application/json",
                    },
                    success: function (response) {
                        Tost("Previous month plan added successfully!");
                        loadBudgetPlan();
                    },
                    error: function (xhr, status, error) {
                        Tost("Failed to add previous month plan.", "error");
                        console.error("AJAX Error:", error);
                        console.log("Response:", xhr.responseText);
                    },
                });
            }
        });
    });
    if (!canEdit()) {
        $(".add_column").remove();
        $(".list_column").removeClass("col-md-8").addClass("col-md-12");
    }
    
});
