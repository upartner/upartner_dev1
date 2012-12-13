function login() {
    var scope = "https://www.google.com/calendar/feeds";
    var token = google.accounts.user.login(scope);
}

function logout() {
    var token = google.accounts.user.logout();
}
        
       