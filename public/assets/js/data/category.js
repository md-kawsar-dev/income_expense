function fetchIncomeByData() {
    return $.ajax({
        url: `${BASE_URL}/api/category`,
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

function initializeCategoryTable() {
    let index = 1;
    fetchIncomeByData().done(function (data) {
        console.log(data.data);

        // Destroy old instance if exists
        if ($.fn.dataTable.isDataTable("#categoryTable")) {
            $("#categoryTable").DataTable().clear().destroy();
        }
        $("#categoryTable").DataTable({
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
                { data: "category_type", title: "Type" },
                { data: "category_name", title: "Category" },
                { data: "amount", title: "Amount" },
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
    $("#category_type").val("");
    $("#category_name").val("");
    $("#store_id").val("");
    $(".add_update_text").text("Add");
}
function addCategory() {
    let name = $("#category_name").val();
    let type = $("#category_type").val();
    let amount = $("#amount").val();
    let data = { category_type: type,category_name: name, amount: amount };
    
    $.ajax({
        url: `${BASE_URL}/api/category`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function (response) {
            Tost("Category added successfully!");
            clearForm();
            initializeCategoryTable();
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
                Tost("Failed to add Category.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateCategory() {
    let id = $("#store_id").val();
    let name = $("#category_name").val();
    let type = $("#category_type").val();
    let amount = $("#amount").val();
    let data = { category_type: type,category_name: name, amount: amount };
    $.ajax({
        url: `${BASE_URL}/api/category/${id}`,
        type: "PUT",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function (response) {
            clearForm();
            Tost("Category updated successfully!");
            initializeCategoryTable();
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
function deleteCategory(id) {
    $.ajax({
        url: `${BASE_URL}/api/category/${id}`,
        type: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        success: function (response) {
            initializeCategoryTable();
            Tost("Category deleted successfully!");
            // Reload the DataTable
        },
        error: function (xhr, status, error) {
            Tost("Failed to delete Category.", "error");
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
            updateCategory();
        } else {
            // Add new category
            addCategory();
        }
    });
    $("#categoryTable")
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
                    deleteCategory(id);
                }
            });
        })
        .on("click", ".edit-btn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            // Fetch existing data
            $.ajax({
                url: `${BASE_URL}/api/category/${id}`,
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    accept: "application/json",
                },
                dataType: "json",
                success: function (data) {
                    $("#category_name").val(data.data.category_name);
                    $("#category_type").val(data.data.category_type);
                    $("#amount").val(data.data.amount);
                    $("#store_id").val(data.data.id);
                    $(".add_update_text").text("Update");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Response:", xhr.responseText);
                },
            });
        });

    initializeCategoryTable();
});
