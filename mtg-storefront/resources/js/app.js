import './bootstrap';

// Sorting / filter function for products table
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("sorting");

    if(select) {
        select.addEventListener("change", function () {
            this.form.submit();
        });
    }
});