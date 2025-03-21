document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".custom-dropdown");
    const selected = document.getElementById("selected-privacy");
    const options = document.querySelector(".dropdown-options");
    const hiddenInput = document.getElementById("privacy");

    // Toggle dropdown options
    selected.addEventListener("click", function () {
        options.style.display = options.style.display === "block" ? "none" : "block";
    });

    // Select an option
    options.querySelectorAll("li").forEach(option => {
        option.addEventListener("click", function() {
            selected.querySelector("span").textContent = this.textContent;
            selected.querySelector("#privacy-icon").src = `assets/${this.textContent}_Icon.svg`;
            selected.setAttribute("data-value", this.getAttribute("data-value"));
            hiddenInput.value = this.getAttribute("data-value");
            options.style.display = "none";
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!dropdown.contains(event.target)) {
            options.style.display = "none";
        }
    });
});
