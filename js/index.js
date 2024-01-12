document.addEventListener("click", function (event) {
    var categoriesDropdown = document.getElementById("categoriesDropdown");
    var categoriesButton = document.querySelector("li button");

    if (event.target !== categoriesButton && !categoriesDropdown.contains(event.target)) {
        categoriesDropdown.style.display = "none";
    }
});

function toggleCategories() {
    var categoriesDropdown = document.getElementById("categoriesDropdown");
    categoriesDropdown.style.display = (categoriesDropdown.style.display === "none" || categoriesDropdown.style.display === "") ? "block" : "none";
}

function send(obj){
    window.location.href = `search.php?type=${obj.dataset.type}`
}

function search(){
    window.location.href = `search.php?name=${document.getElementById('barraSearch').value}`
}