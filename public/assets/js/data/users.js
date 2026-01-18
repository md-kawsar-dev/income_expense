function fetchData() {
    return $.ajax({
        url: `${BASE_URL}/api/users`,
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

function initializeUsersTable() {
    let index = 1;
    fetchData().done(function (data) {
        // Destroy old instance if exists
        if ($.fn.dataTable.isDataTable("#usersTable")) {
            $("#usersTable").DataTable().clear().destroy();
        }
        $("#usersTable").DataTable({
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
                { data: "name", title: "Name" },
                { data: "username", title: "Username" },
                { data: "email", title: "Email" },
                { data: "phone", title: "Phone" },
                { data: "role.name", title: "Role" },
                {
                    data: null,
                    title: "Action",
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group" role="group" aria-label="Action Buttons"></div>
                                
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
                            </div>
                        `;
                    },
                },
            ],
        });
    });
}
function clearForm() {
    $("#role_id").val("").trigger("change");
    $("#name").val("");
    $("#username").val("");
    $("#email").val("");
    $("#phone").val("");
    $("#store_id").val("");
    $(".add_update_text").text("Add");
}
function getFormData(){
    let role_id = $("#role_id").val();
    let name = $("#name").val();
    let username = $("#username").val();
    let email = $("#email").val();
    let phone = $("#phone").val();
    return { role_id: role_id, name: name, username: username, email: email, phone: phone,password:"123456", password_confirmation:"123456" };
}
function addUser() {
    $.ajax({
        url: `${BASE_URL}/api/users`,
        type: "POST",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        data: JSON.stringify(getFormData()),
        contentType: "application/json",
        success: function (response) {
            Tost("User added successfully!");
            clearForm();
            initializeUsersTable();
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
                Tost("Failed to add User.", "error");
                console.error("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
    });
}
function updateUser() {
    let id = $("#store_id").val();
    $.ajax({
        url: `${BASE_URL}/api/users/${id}`,
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
            Tost("User updated successfully!");
            initializeUsersTable();
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
function deleteUser(id) {
    $.ajax({
        url: `${BASE_URL}/api/users/${id}`,
        type: "DELETE",
        headers: {
            Authorization: "Bearer " + getAuthToken(),
            accept: "application/json",
        },
        dataType: "json",
        success: function (response) {
            initializeUsersTable();
            Tost("User deleted successfully!");
            // Reload the DataTable
        },
        error: function (xhr, status, error) {
            Tost("Failed to delete User.", "error");
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
            updateUser();
        } else {
            // Add new category
            addUser();
        }
    });
    $("#usersTable")
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
                    deleteUser(id);
                }
            });
        })
        .on("click", ".edit-btn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            // Fetch existing data
            $.ajax({
                url: `${BASE_URL}/api/users/${id}`,
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getAuthToken(),
                    accept: "application/json",
                },
                dataType: "json",
                success: function (data) {
                    $("#role_id").val(data.data.role_id).trigger("change");
                    $("#name").val(data.data.name);
                    $("#email").val(data.data.email);
                    $("#username").val(data.data.username);
                    $("#phone").val(data.data.phone);
                    $("#store_id").val(data.data.id);
                    $(".add_update_text").text("Update");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Response:", xhr.responseText);
                },
            });
        });

    initializeUsersTable();
});
