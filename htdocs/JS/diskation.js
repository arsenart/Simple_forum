/**
 * @file
 * Handles the search functionality using AJAX.
 */

/**
 * Adds a DOMContentLoaded event listener to initialize the search functionality.
 */
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Adds an input event listener to the search input field.
     */
    document.getElementById('search').addEventListener('input', function () {

        var query = this.value;
        if (query !== "") {
            var xhr = new XMLHttpRequest();


            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('search-results').innerHTML = xhr.responseText;
                }
            };

            xhr.open('POST', 'src/search.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


            xhr.send('query=' + encodeURIComponent(query));
        } else {

            document.getElementById('search-results').innerHTML = '';
        }
    });
});
