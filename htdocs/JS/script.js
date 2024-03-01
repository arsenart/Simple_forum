/**
 * @file
 * Handles the photo upload form interactions.
 */

/**
 * The container element for the upload photo form.
 * @type {HTMLElement}
 */
let container = document.getElementById('upload_photo_form');

/**
 * Event listener for the 'popup' element click event.
 */
container.querySelector('#popup').addEventListener("click", show);

/**
 * Event listener for the 'popup_none' element click event.
 */
container.querySelector('#popup_none').addEventListener("click", hide);

/**
 * The input element for photo upload.
 * @type {HTMLElement}
 */
let input = container.querySelector('.photo_upload');

/**
 * The submit button for the photo upload form.
 * @type {HTMLElement}
 */
let submit = container.querySelector('.submit');

/**
 * The 'popup' element in the form.
 * @type {HTMLElement}
 */
let popup = container.querySelector('#popup');

/**
 * The 'popup_none' element in the form.
 * @type {HTMLElement}
 */
let popup_none = container.querySelector('#popup_none');

/**
 * Function to show the photo upload form.
 */
function show() {
    input.style.display = "block";
    submit.type = 'submit';
    popup.style.display = 'None';
    popup_none.style.display = 'block';
}

/**
 * Function to hide the photo upload form.
 */
function hide() {
    input.style.display = "None";
    submit.type = 'hidden';
    popup.style.display = 'block';
    popup_none.style.display = 'None';
}
