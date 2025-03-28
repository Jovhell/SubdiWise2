document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".custom-dropdown");
    const selected = document.getElementById("selected-privacy");
    const options = document.querySelector(".dropdown-options");
    const hiddenInput = document.getElementById("privacy");
    const postMenus = document.querySelectorAll(".post-menu")
    const postMeatBalls = document.querySelectorAll('.meatball')
    const editPostModals = document.querySelectorAll('.edit-post-modal')
    const modalOverlays = document.querySelectorAll('.modal-overlay')
    const attachmentsArea = document.getElementById('attachments')
    const fileInput = document.getElementById("file")
    const imageInput = document.getElementById("image")
    const likeBtns = document.querySelectorAll(".like")

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

    selected.addEventListener("click", function () {
        options.style.display = options.style.display === "block" ? "none" : "block";
    });

    options.querySelectorAll("li").forEach(option => {
        option.addEventListener("click", function() {
            selected.querySelector("span").textContent = this.textContent;
            selected.querySelector("#privacy-icon").src = `assets/${this.textContent}_Icon.svg`;
            selected.setAttribute("data-value", this.getAttribute("data-value"));
            hiddenInput.value = this.getAttribute("data-value");
            options.style.display = "none";
        });
    });

    document.addEventListener("click", function (event) {
        if (!dropdown.contains(event.target)) {
            options.style.display = "none";
        }

        editPostModals.forEach((modal, i) => {
            if(!modal.contains(event.target)) {
                modal.classList.remove('show')
                modalOverlays[i].classList.remove('show')
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
                modalOverlays[i].classList.add('show')
                menu.classList.remove('show')
            }

            cancel.addEventListener('click', () => {
                editPostModals[i].classList.remove('show')
                modalOverlays[i].classList.remove('show')
            })
        })
    });

    fileInput.addEventListener("change", e => {
        const fileList = e.target.files

        for(let file of fileList) {
            const reader = new FileReader()
            reader.onload = function(e) {
                const preview = displayImage(e.target.result, fileInput, fileList, file)

                attachmentsArea.appendChild(preview)
            }
            reader.readAsDataURL(file)
        }
    })

    likeBtns.forEach(button => {
        button.addEventListener('click', () => {
            const postId = button.dataset.postId;
            const isDislike = button.dataset.isDislike
            
            const formData = new FormData();
            formData.append('post_id', postId);
            formData.append('isDislike', isDislike);

            fetch("/likepost", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                if(data.status == "liked") {
                    const count = parseInt(button.dataset.count) + 1

                    button.classList.add("filled")
                    button.querySelector('span').textContent = count
                    button.dataset.count = count
                    button.dataset.isDislike = 1
                }

                if(data.status == "disliked") {
                    const count = parseInt(button.dataset.count) - 1

                    button.classList.remove("filled")
                    button.querySelector('span').textContent = count > 0 ? count : '';
                    button.dataset.count = count
                    button.dataset.isDislike = 0
                }
            })
        })
    })

    imageInput.addEventListener("change", e => {
        const fileList = e.target.files

        for(let file of fileList) {
            const reader = new FileReader()
            reader.onload = function(e) {
                const preview = displayImage(e.target.result, imageInput, fileList, file)

                attachmentsArea.appendChild(preview)
            }
            reader.readAsDataURL(file)
        }
    })

    function displayImage(src, input, fileList, file) {
        const img = document.createElement('img')
        img.src = src
        
        const imgContainer = document.createElement('div')
        imgContainer.classList.add('image-container')
    
        const closeBtn = document.createElement('button')
        closeBtn.innerHTML = '&times;'
        closeBtn.classList.add('remove-attachment-btn')
        closeBtn.type = "button"
        closeBtn.onclick = () => {
            attachmentsArea.removeChild(imgContainer)
            
            const dataTransfer = new DataTransfer()

            const filesArray = Array.from(fileList).filter((el) => el != file)

            filesArray.forEach((el) => dataTransfer.items.add(el))

            input.files = dataTransfer.files
        }
    
        imgContainer.appendChild(img)
        imgContainer.appendChild(closeBtn)
    
        return imgContainer
    }
});

