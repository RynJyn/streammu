function showMenu() {
var menu = document.getElementById('menu');

if(!menu.style.display || menu.style.display=="none")
{
menu.style.display = "block"; //If the menu is hidden, show the menu
}
else 
{
menu.style.display = "none"; //If the menu is visible, hide the menu
}
}

function goBack() {
    window.history.back(); //Go to the page the user was previously on
}