import './bootstrap';
import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

// Sorting / filter function for products table
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("sorting");
    const filterForm = select?.form;

    if(select) {
        select.addEventListener("change", function () {
            this.form.submit();
        });
    }

    // Auto-submit on checkbox change (category & color filters)
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="category[]"], input[type="checkbox"][name="color[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function () {
            if (filterForm) {
                cleanFormBeforeSubmit(filterForm);
                filterForm.submit();
            }
        });
    });

    // Helper function to remove default/empty values from form before submit
    function cleanFormBeforeSubmit(form) {
        const priceSlider = document.getElementById('price-slider');
        const stockSlider = document.getElementById('stock-slider');
        
        // Remove price inputs if at default values
        if (priceSlider) {
            const minInput = document.getElementById('min_price_input');
            const maxInput = document.getElementById('max_price_input');
            // Round global values same way as slider values for consistent comparison
            const globalMin = Math.floor(parseFloat(priceSlider.dataset.min));
            const globalMax = Math.ceil(parseFloat(priceSlider.dataset.max));
            const currentMin = parseFloat(minInput.value);
            const currentMax = parseFloat(maxInput.value);
            
            // Disable if values are at or beyond global defaults
            if (currentMin <= globalMin) {
                minInput.disabled = true;
            }
            if (currentMax >= globalMax) {
                maxInput.disabled = true;
            }
        }
        
        // Remove stock inputs if at default values
        if (stockSlider) {
            const minInput = document.getElementById('min_stock_input');
            const maxInput = document.getElementById('max_stock_input');
            const globalMin = Math.floor(parseFloat(stockSlider.dataset.min));
            const globalMax = Math.ceil(parseFloat(stockSlider.dataset.max));
            const currentMin = parseFloat(minInput.value);
            const currentMax = parseFloat(maxInput.value);
            
            if (currentMin <= globalMin) {
                minInput.disabled = true;
            }
            if (currentMax >= globalMax) {
                maxInput.disabled = true;
            }
        }
    }

    // Price range slider
    const priceSlider = document.getElementById('price-slider');
    
    if (priceSlider) {
        const min = parseFloat(priceSlider.dataset.min);
        const max = parseFloat(priceSlider.dataset.max);
        const currentMin = parseFloat(priceSlider.dataset.currentMin);
        const currentMax = parseFloat(priceSlider.dataset.currentMax);

        noUiSlider.create(priceSlider, {
            start: [currentMin, currentMax],
            connect: true,
            range: {
                'min': min,
                'max': max
            },
            step: 1
        });
        
        priceSlider.noUiSlider.on('update', function (values) {
            document.getElementById('min-price').textContent = Math.floor(values[0]);
            document.getElementById('max-price').textContent = Math.ceil(values[1]);
            
            document.getElementById('min_price_input').value = Math.floor(values[0]);
            document.getElementById('max_price_input').value = Math.ceil(values[1]);
        });

        // Auto-submit when user releases the slider
        priceSlider.noUiSlider.on('change', function () {
            if (filterForm) {
                cleanFormBeforeSubmit(filterForm);
                filterForm.submit();
            }
        });
    }
    
    
    // Stock range slider
    const stockSlider = document.getElementById('stock-slider');
    
    if (stockSlider) {
        const min = parseFloat(stockSlider.dataset.min);
        const max = parseFloat(stockSlider.dataset.max);
        const currentMin = parseFloat(stockSlider.dataset.currentMin);
        const currentMax = parseFloat(stockSlider.dataset.currentMax);

        noUiSlider.create(stockSlider, {
            start: [currentMin, currentMax],
            connect: true,
            range: {
                'min': min,
                'max': max
            },
            step: 10
        });
        
        stockSlider.noUiSlider.on('update', function (values) {
            document.getElementById('min-stock').textContent = Math.round(values[0]);
            document.getElementById('max-stock').textContent = Math.round(values[1]);
            
            document.getElementById('min_stock_input').value = Math.round(values[0]);
            document.getElementById('max_stock_input').value = Math.round(values[1]);
        });

        // Auto-submit when user releases the slider
        stockSlider.noUiSlider.on('change', function () {
            if (filterForm) {
                cleanFormBeforeSubmit(filterForm);
                filterForm.submit();
            }
        });
    }
});