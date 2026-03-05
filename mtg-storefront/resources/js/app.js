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
            document.getElementById('min-price').textContent = Math.round(values[0]);
            document.getElementById('max-price').textContent = Math.round(values[1]);
            
            document.getElementById('min_price_input').value = Math.round(values[0]);
            document.getElementById('max_price_input').value = Math.round(values[1]);

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
    }
});