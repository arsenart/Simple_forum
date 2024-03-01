/**
 * @file
 * Handles form submission for the main registration form.
 */

/**
 * Adds a submit event listener to the main registration form.
 */
document.getElementById("main-form").addEventListener("submit", registerForm);

/**
 * Function to handle the submission of the registration form.
 * @param {Event} event - The form submission event.
 */
function registerForm(event) {
    // Get the form element.
    const formElement = document.getElementById("main-form");

    // Retrieve values from form fields.
    const name = formElement.name.value;
    const pass = formElement.password.value;
    const repass = formElement.repass.value;

    // Variable to store error messages.
    let fail = "";

    // Check if name or password is empty.
    if (name === "" || pass === "") {
        event.preventDefault();
        fail = "Fill all fields again";
    } else if (pass !== repass) {  // Check if passwords match.
        event.preventDefault();
        fail = "Repass password is incorrect";
    }

    // Display error message if there is one.
    if (fail !== "") {
        document.getElementById("error").innerHTML = fail;
    }
}
