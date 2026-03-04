import './bootstrap';
import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

// Sorting / filter function for products table
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("sorting");

    if(select) {
        select.addEventListener("change", function () {
            this.form.submit();
        });
    }

    // Price range slider
    const priceSlider = document.getElementById('price-slider');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [0, 100],
            connect: true,
            range: {
                'min': 0,
                'max': 100 // UPDATE TO DYNAMIC HIGHEST PRICE
            },
            step: 1
        });
        
        priceSlider.noUiSlider.on('update', function (values) {
            minPriceInput.value = Math.round(values[0]);
            maxPriceInput.value = Math.round(values[1]);
        });
    }
    
    
    // Stock range slider
    const stockSlider = document.getElementById('stock-slider');
    const minStockInput = document.getElementById('min-stock');
    const maxStockInput = document.getElementById('max-stock');
    
    if (stockSlider) {
        noUiSlider.create(stockSlider, {
            start: [0, 100],
            connect: true,
            range: {
                'min': 0,
                'max': 100 // UPDATE TO DYNAMIC HIGHEST STOCK
            },
            step: 1
        });
        
        stockSlider.noUiSlider.on('update', function (values) {
            minStockInput.value = Math.round(values[0]);
            maxStockInput.value = Math.round(values[1]);
        });
    }
});