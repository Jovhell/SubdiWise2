const inputs = document.querySelectorAll("input")
const capitalize = str => str.charAt(0).toUpperCase() + str.slice(1);

inputs.forEach(input => {
    input.addEventListener("input", () => {
        let errorLabel = input.parentElement.querySelector(".error-message");
        if (errorLabel) {
            errorLabel.classList.remove('error-message')
            errorLabel.innerText = capitalize(errorLabel.htmlFor)
        }
    });
});
