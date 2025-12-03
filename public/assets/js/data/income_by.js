function fetchIncomeByData() {
    return $.ajax({
        url: `${BASE_URL}/api/income-by`,
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

function initializeIncomeByTable() {
    fetchIncomeByData().done(function (data) {
        // Destroy old instance if exists
        if ($.fn.dataTable.isDataTable("#incomeByTable")) {
            $("#incomeByTable").DataTable().clear().destroy();
        }
        $("#incomeByTable").DataTable({
            responsive: true,
            processing: true,
            serverSide: false,
            data: data.data, // pass fetched data here
            columns: [
                { data: "id", title: "ID" },
                { data: "name", title: "Name" },
                {
                    data: null,
                    title: "Action",
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn delete_income_btn" data-id="${row.id}">Delete</button>
                        `;
                    },
                },
            ],
        });
    });
}
function IncomeBySubmit(event) {
    let name = $("#income_by_name").val();
    $.ajax({
        url: `${BASE_URL}/api/income-by`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify({ name: name }),
        contentType: "application/json",
        success: function (response) {
            alert("Income By added successfully!");
            $("#income_by_name").val(""); // Clear the input field
            // Reload the DataTable
            initializeIncomeByTable();
        },
        error: function (xhr, status, error) {
            // validation error handling
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMessages = Object.values(errors)
                    .map((errArray) => errArray.join(", "))
                    .join("\n");
                alert(errorMessages);
            } else {
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function deleteIncomeBy(id) {
    if (!confirm("Are you sure you want to delete this Income By?")) {
        return;
    }
    $.ajax({
        url: `${BASE_URL}/api/income-by/${id}`,
        type: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        success: function (response) {
            initializeIncomeByTable();
            alert("Income By deleted successfully!");
            // Reload the DataTable
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            console.log("Response:", xhr.responseText);
        },
    });
}
$(document).ready(function () {
   
     $('#incomeByTable').off('click', '.delete_income_btn').on('click', '.delete_income_btn', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let confirmDelete = confirm("Are you sure you want to delete this Income By?");
        if (confirmDelete) {
            deleteIncomeBy(id);
        }
    });
    initializeIncomeByTable();
});
