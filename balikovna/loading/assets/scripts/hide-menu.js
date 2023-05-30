const menu = document.getElementsByClassName("profile-menu");
const popUpWindow = document.getElementsByClassName("pop-up-window");
const profilePicture = document.getElementById("profile-icon-link");
const mainContent = document.getElementById("main-content-grid");
const recievePaymentButton = document.getElementById("footer-button");

mainContent.onclick = function() {
    for(i = 0; i < menu.length; ++i)menu[i].classList.add("hidden");
}

profilePicture.onclick = function() {
    for(i = 0; i < menu.length; ++i)menu[i].classList.toggle("hidden");
}