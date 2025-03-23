document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".custom-dropdown");
    const selected = document.getElementById("selected-privacy");
    const options = document.querySelector(".dropdown-options");
    const hiddenInput = document.getElementById("privacy");
    const postMenus = document.querySelectorAll(".post-menu")
    const postMeatBalls = document.querySelectorAll('.meatball')
    const editPostModals = document.querySelectorAll('.edit-post-modal')

    postMeatBalls.forEach((meatball, i) => {
        meatball.addEventListener('click', (e) => {
            e.stopPropagation()
            postMenus.forEach(menu => {
                if(menu == postMenus[i]) {
                    menu.classList.toggle('show')
                } else {
                    menu.classList.remove('show')
                }
            })
        })
    })

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

        editPostModals.forEach((modal, i) => {
            if(!modal.contains(event.target)) {
                modal.classList.remove('show')
            }
        })

        postMenus.forEach((menu, i) => {
            if(!menu.contains(event.target)) {
                menu.classList.remove('show')
                return
            }
            
            const edit = menu.querySelector('.edit')
            const cancel = editPostModals[i].querySelector('.modal-cancel')

            if(event.target == edit) {
                editPostModals[i].classList.add('show')
                menu.classList.remove('show')
            }

            cancel.addEventListener('click', () => {
                editPostModals[i].classList.remove('show')
            })
        })
    });
});
