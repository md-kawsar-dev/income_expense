async function loadCategory() {
    try {
        let response = await fetch(`${BASE_URL}/api/category`, {
            method: "GET",
            headers: {
                Authorization: "Bearer " + getAuthToken(),
                Accept: "application/json",
            },
        });

        let result = await response.json(); // Convert response → JSON
        let categories = result.data;

        let html = '<option value="">Select Category</option>';
        categories.forEach((category) => {
            html += `<option value="${category.id}">${category.category_name} (${category.category_type})</option>`;
        });
        $("#category_id").html(html);
        $("#category_id").select2();
    } catch (error) {
        let html = '<option value="">Select Category</option>';
        $("#category_id").html(html);
        $("#category_id").select2();
    }
}

async function loadBudgetPlan() {
    let budgetPlanTableBody = $("#budgetPlanTable tbody");

    // Loading message
    budgetPlanTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );

    let response = await fetch(`${BASE_URL}/api/budget-plan`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });

    let result = await response.json();
    let budgetPlans = result.data;

    budgetPlanTableBody.empty();

    if (budgetPlans.length === 0) {
        budgetPlanTableBody.html(
            `<tr><td class="text-center" colspan="100%">No data available</td></tr>`
        );
        return;
    }

    // Sort budgetPlans by category_type according to custom order
    const categoryOrder = ["Need", "Want", "Savings"];
    budgetPlans.sort((a, b) => {
        return (
            categoryOrder.indexOf(a?.category?.category_type) -
            categoryOrder.indexOf(b?.category?.category_type)
        );
    });

    let row = "";
    let totalAmount = 0;

    let currentCategory = null;
    let categoryTotal = 0;

    budgetPlans.forEach((plan, index) => {
        totalAmount += parseFloat(plan.amount);
        // If category changes, insert category header row
        if (plan?.category?.category_type !== currentCategory) {
            // Print total of previous category
            if (currentCategory !== null) {
                row += `<tr class="bg-secondary">
                            <th style="color:white;" colspan="2" class="text-end">${currentCategory} Total</th>
                            <th style="color:white;">${categoryTotal.toString().replace(/\.0+$/, "")}</th>
                            <th></th>
                        </tr>`;
            }

            // New category header
            currentCategory = plan?.category?.category_type;
            categoryTotal = 0; // reset category total

            row += `<tr class="text-center">
                        <th style="font-weight:bold;" colspan="4">${currentCategory}</th>
                    </tr>`;
        }

        categoryTotal += parseFloat(plan.amount);

        // Normal budget row
        row += `<tr>
            <td>${index + 1}</td>
            <td>${plan?.category?.category_name}</td>
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

    // Print total for last category
    if (currentCategory !== null) {
        row += `<tr class="bg-secondary" >
                    <th style="color:white;" colspan="2" class="text-end">${currentCategory} Total</th>
                    <th style="color:white;">${categoryTotal.toString().replace(/\.0+$/, "")}</th>
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
    $("#category_id").val(budgetPlan.category_id).trigger("change");
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
    let year_month = $("#year_month").val();
    let category_id = $("#category_id").val();
    let amount = $("#amount").val();
    return { year_month: year_month, category_id: category_id, amount: amount };
}
function clearForm() {
    $("#year_month").val("");
    $("#category_id").val("").trigger("change");
    $("#amount").val("");
}
function storeBudgetPlan() {
    let data = getInputData();
    $.ajax({
        url: `${BASE_URL}/api/budget-plan`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
        data: data,
        success: function (response) {
            clearForm();
            Tost("Budget plan saved successfully!");
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
                Tost("Failed to save budget plan.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateBudgetPlan() {
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
    loadCategory();
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
    $("#submitButton").on("click", function (e) {
        e.preventDefault();
        let store_id = $("#store_id").val();
        if (store_id) {
            // update
            updateBudgetPlan();
        } else {
            // new
            storeBudgetPlan();
        }
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
