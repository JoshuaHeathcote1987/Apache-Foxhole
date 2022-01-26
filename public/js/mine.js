const currentLocation = location.href;
const menuItem = document.querySelectorAll('a');
console.log(currentLocation + menuItem)
for (let index = 0; index < menuItem.length; index++) {
    if (menuItem[index].href === currentLocation) {
        menuItem[index].className = "nav-link text-white active";
    } 
}