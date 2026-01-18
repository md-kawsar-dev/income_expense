async function loadAddIncomeBy() {
    try {
        let response = await fetch(
            `${BASE_URL}/api/users`,
            {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    Accept: "application/json",
                },
            }
        );

        let result = await response.json(); // Convert response → JSON
        let users = result.data;

        let html = '<option value="">Select Income By</option>';
        users.forEach((user) => {
            html += `<option value="${user.id}">${user.name}</option>`;
        });
        $("#income_by_id").html(html);
        $("#income_by_id_search").html(html);
        $("#income_by_id").select2();
        $("#income_by_id_search").select2();
    } catch (error) {
        let html = '<option value="">Select Income By</option>';
        $("#income_by_id").html(html);
        $("#income_by_id_search").html(html);
        $("#income_by_id").select2();
        $("#income_by_id_search").select2();
    }
}
async function loadIncomeList(filters = {}) {
    let {
        year = null,
        month = null,
        date = null,
        income_by_id = null,
    } = filters;
    let incomeTableBody = $("#incomeTable tbody");

    // Loading message
    incomeTableBody.html(
        `<tr><td class="text-center" colspan="100%">Loading...</td></tr>`
    );
    let queryParams = new URLSearchParams();
    if (date) queryParams.append("date", date);
    if (year) queryParams.append("year", year);
    if (month) queryParams.append("month", month);
    if (income_by_id) queryParams.append("income_by_id", income_by_id);
    let response = await fetch(
        `${BASE_URL}/api/income?${queryParams.toString()}`,
        {
            method: "GET",
            headers: {
                Authorization: "Bearer " + getAuthToken(),
                Accept: "application/json",
            },
        }
    );

    let result = await response.json();
    let incomes = result.data;
    
    incomeTableBody.html("");
    let row = "";
    if (incomes.length === 0) {
        row = `<tr><td class="text-center" colspan="100%">No data available</td></tr>`;
    }
    let totalAmount = 0;
    incomes.forEach((income, index) => {
        totalAmount += parseFloat(income.amount);
        row += `<tr>
            <td>${index + 1}</td>
            <td>
                ${
                    canEdit()
                        ? `<button class="btn btn-sm btn-primary edit-btn" data-id="${income.id}">Edit</button>`
                        : ""
                }
                ${
                    canDelete()
                        ? `<button class="btn btn-sm btn-danger delete_btn" data-id="${income.id}">Delete</button>`
                        : ""
                }
            </td>
            <td>${moment(income.date).format("DD MMM, YYYY")}</td>
            <td>${income.income_by.name}</td>
            <td>${Number(income.amount.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
            <td>${income.description || ""}</td>
        </tr>`;
    });
    if (incomes.length > 0) {
        row += `<tr>
            <td colspan="4" class="text-end"><strong>Total:</strong></td>
            <td>${Number(totalAmount.toString().replace(/\.0+$/, "")).toLocaleString()}</td>
            <td></td>
        </tr>`;
    }
    incomeTableBody.html(row);
}

async function editIncome(id) {
    // Implement edit functionality if needed
    let response = await fetch(`${BASE_URL}/api/income/${id}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });
    let result = await response.json();
    let income = result.data;
    $("#date").val(income.date);
    $("#income_by_id").val(income.income_by_id).trigger("change");
    $("#amount").val(income.amount.toString().replace(/\.0+$/, ""));
    $("#description").val(income.description);
    $("#store_id").val(income.id);
    $(".add_update_text").text("Update");
}
async function deleteIncome(id) {
    // Implement edit functionality if needed
    let response = await fetch(`${BASE_URL}/api/income/${id}`, {
        method: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
    });
    if (!response.ok) {
        Tost("Failed to delete income.", "error");
        return;
    }
    Tost("Income deleted successfully!");
    loadIncomeList(getSearchData());
}
function getInputData() {
    let date = $("#date").val();
    let income_by_id = $("#income_by_id").val();
    let amount = $("#amount").val();
    let description = $("#description").val();
    return {
        date: date,
        income_by_id: income_by_id,
        amount: amount,
        description: description,
    };
}
function getSearchData() {
    let year = $("#year_search").val();
    let month = $("#month_search").val();
    let date = $("#date_search").val();
    let income_by_id = $("#income_by_id_search").val();
    return {
        year,
        month,
        date,
        income_by_id,
    };
}
function clearForm() {
    $("#date").val("");
    $("#income_by_id").val("").trigger("change");
    $("#amount").val("");
    $("#description").val("");
    $("#store_id").val("");
    $(".add_update_text").text("Add");
}
function storeIncome() {
    let data = getInputData();
    $.ajax({
        url: `${BASE_URL}/api/income`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
        data: data,
        success: function (response) {
            clearForm();
            Tost("Income saved successfully!");
            loadIncomeList(getSearchData());
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
                Tost("Failed to save income.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateIncome() {
    let id = $("#store_id").val();
    let data = getInputData();
    $.ajax({
        url: `${BASE_URL}/api/income/${id}`,
        type: "PUT",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            Accept: "application/json",
        },
        data: data,
        success: function (response) {
            clearForm();
            Tost("Income updated successfully!");
            $(".add_update_text").text("Add");
            $("#store_id").val("");
            loadIncomeList(getSearchData());
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
                Tost("Failed to update income.", "error");
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
        loadIncomeList(getSearchData());
    });
    $("#refreshButton").on("click", function (e) {
        e.preventDefault();
        loadIncomeList();
    });
    $("#date").on("change click", function () {
        if ($(this).val()) {
            loadAddIncomeBy();
        }
    });
   
    $("#submitButton").on("click", function (e) {
        e.preventDefault();
        let store_id = $("#store_id").val();
        if (store_id) {
            // update
            updateIncome();
        } else {
            // new
            storeIncome();
        }
    });

    $("#amount").on("keydown", function (e) {
        if (e.key === "Enter") {
            if (e.key === "Enter") {
                let expression = $(this).val();

                // "=" check 
                // if (expression.indexOf("=") === -1) {
                //     return;
                // }

                // "=" if present, remove it
                expression = expression.replace("=", "");

                try {
                    let result = eval(expression);
                    $(this).val(result);
                } catch (error) {
                    alert("Invalid Expression!");
                }
            }
        }
    });

    $("#incomeTable")
        .on("click", ".edit-btn", function () {
            let id = $(this).data("id");
            // Implement edit functionality if needed
            editIncome(id);
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
                    deleteIncome(id);
                }
            });
        });
    loadAddIncomeBy();
    loadIncomeList();


    if (!canEdit()) {
        $(".add_column").remove();
        $(".list_column").removeClass("col-md-8").addClass("col-md-12");
    }
});
