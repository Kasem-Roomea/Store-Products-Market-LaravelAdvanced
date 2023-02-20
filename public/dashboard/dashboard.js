let mainSidebar = document.querySelector(".main-sidebar");

// toggle sidebar
let sidebarIcons = document.querySelectorAll(".toggle-sidebar-icon");
for (let item of sidebarIcons) {
    item.addEventListener("click", function () {
        mainSidebar.classList.toggle("open");
    });
}

// close sidebar onclick anywhere except sidebar and toggle icon 
window.addEventListener("click", (e) => {
    if(mainSidebar.classList.contains("open") && window.innerWidth <= 1199.98 && !e.target.closest(".main-sidebar, .toggle-sidebar-icon")) {
        mainSidebar.classList.remove("open");
    } else {
        return;
    }
});

if(window.innerWidth <= 1199.98) {
    
}
// open sidebar onclick (any nav item)
let navItems = document.querySelectorAll(".main-sidebar .nav-item");
for(item of navItems) {
    item.addEventListener("click", function () {
        mainSidebar.classList.contains("open") ? '' : mainSidebar.classList.add("open");
    });
}

// toggle submenu
let clicked = true;
document.querySelectorAll(".main-sidebar.open .nav-item a.parent").forEach(item => {
    item.addEventListener("click", function (e) {
        if (clicked == true) {
            clicked = false;
            item.nextElementSibling.classList.toggle("open");
            item.querySelector(".arrow-icon").classList.toggle("rotate");
            setTimeout(() => {
                clicked = true;
            }, 400);
        } else {
            e.preventDefault();
        }
    });
});