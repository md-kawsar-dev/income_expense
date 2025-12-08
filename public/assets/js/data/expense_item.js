function fetchIncomeByData() {
    return $.ajax({
        url: `${BASE_URL}/api/expense-items`,
        type: "GET",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            console.log("Response:", xhr.responseText);
        },
    });
}

function initializeExpenseItemTable() {
    let index = 1;
    fetchIncomeByData().done(function (data) {
        console.log(data.data);

        // Destroy old instance if exists
        if ($.fn.dataTable.isDataTable("#expenseItemTable")) {
            $("#expenseItemTable").DataTable().clear().destroy();
        }
        $("#expenseItemTable").DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            data: data.data, // pass fetched data here
            columns: [
                {
                    data: null,
                    title: "ID",
                    render: function () {
                        return index++;
                    },
                },
                { data: "expense_type", title: "Type" },
                { data: "expense_item", title: "Expense Item" },
                { data:null, title: "Amount", render: function(data,type,row){
                    if(row.amount === null || row.amount === undefined){
                        return "";
                    }
                    return row.amount.toString().replace(/\.0+$/, "");
                } },
                {
                    data: null,
                    title: "Action",
                    render: function (data, type, row) {
                        return `
                            ${
                                canEdit()
                                    ? `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>`
                                    : ""
                            }
                            ${
                                canDelete()
                                    ? `<button class="btn btn-sm btn-danger delete-btn delete_btn" data-id="${row.id}">Delete</button>`
                                    : ""
                            }
                        `;
                    },
                },
            ],
        });
    });
}
function clearForm() {
    $("#expense_type").val("");
    $("#expense_item").val("");
    $("#store_id").val("");
    $(".add_update_text").text("Add");
}
function getFormData(){
    let type = $("#expense_type").val();
    let item = $("#expense_item").val();
    let amount = $("#amount").val();
    return { expense_type: type, expense_item: item, amount: amount };
}
function addExpenseItem() {
    $.ajax({
        url: `${BASE_URL}/api/expense-items`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify(getFormData()),
        contentType: "application/json",
        success: function (response) {
            Tost("ExpenseItem added successfully!");
            clearForm();
            initializeExpenseItemTable();
        },
        error: function (xhr, status, error) {
            // validation error handling
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                for (let field in errors) {
                    errors[field].forEach((msg) => {
                        Tost(msg, "error");
                    });
                }
            } else {
                Tost("Failed to add ExpenseItem.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateExpenseItem() {
    let id = $("#store_id").val();
    $.ajax({
        url: `${BASE_URL}/api/expense-items/${id}`,
        type: "PUT",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify(getFormData()),
        contentType: "application/json",
        success: function (response) {
            clearForm();
            Tost("ExpenseItem updated successfully!");
            initializeExpenseItemTable();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMessages = Object.values(errors)
                    .map((errArray) => errArray.join(", "))
                    .join("\n");
                Tost(errorMessages, "error");
            }
            console.error("AJAX Error:", error);
            console.log("Response:", xhr.responseText);
        },
    });
}
function deleteExpenseItem(id) {
    $.ajax({
        url: `${BASE_URL}/api/expense-items/${id}`,
        type: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        success: function (response) {
            initializeExpenseItemTable();
            Tost("ExpenseItem deleted successfully!");
            // Reload the DataTable
        },
        error: function (xhr, status, error) {
            Tost("Failed to delete ExpenseItem.", "error");
            console.error("AJAX Error:", error);
            console.log("Response:", xhr.responseText);
        },
    });
}

$(document).ready(function () {
    if (!canEdit()) {
        $(".add_column").remove();
        $(".list_column").removeClass("col-md-8").addClass("col-md-12");
    }
    $(document).on("click", "#submitButton", function (e) {
        e.preventDefault();
        let id = $("#store_id").val();
        if (id) {
            // Update existing category
            updateExpenseItem();
        } else {
            // Add new category
            addExpenseItem();
        }
    });
    $("#expenseItemTable")
        .off("click", ".delete_btn")
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
                    deleteExpenseItem(id);
                }
            });
        })
        .on("click", ".edit-btn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            // Fetch existing data
            $.ajax({
                url: `${BASE_URL}/api/expense-items/${id}`,
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    accept: "application/json",
                },
                dataType: "json",
                success: function (data) {
                    $("#expense_item").val(data.data.expense_item);
                    $("#expense_type").val(data.data.expense_type);
                    $("#amount").val(data.data.amount.toString().replace(/\.0+$/, ""));
                    $("#store_id").val(data.data.id);
                    $(".add_update_text").text("Update");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Response:", xhr.responseText);
                },
            });
        });

    initializeExpenseItemTable();
});
