const BASE_URL = "http://income_expense.test";
function setUserData(user) {
    localStorage.setItem("user", JSON.stringify(user));
}
function getUserData() {
    const user = localStorage.getItem("user");
    return user ? JSON.parse(user) : null;
}
function clearUserData() {
    localStorage.removeItem("user");
}
function isLoggedIn() {
    const user = getUserData();
    if(user) {
        // user is current location is not login page
        if(window.location.pathname === "/login") {
            window.location.href = "/dashboard";
        }
    }else{
        // if user is not logged in and current location is not login page
        if(window.location.pathname !== "/login") {
            window.location.href = "/login";
        }
    }
}
function logout() {
    clearUserData();
    // Optionally, redirect to login page
    window.location.href = "/login";
}
function getAuthToken() {
    const user = getUserData();
    return user ? user.token : null;
}
function roleId() {
    const user = getUserData();
    return user ? user.role.id : null;
}
isLoggedIn();
