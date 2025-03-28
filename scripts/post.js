const button = document.querySelector('.like')

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
