function validate() {
    var x = document.forms["add"]["firstName"].value;
    var y = document.forms["add"]["lastName"].value;
    if (x < 2 || y < 2) {
        alert("Name must be bigger than 2 characters!");
        return false;
    }
}