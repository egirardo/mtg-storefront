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
        noUiSlider.create(priceSlider, {
            start: [0, 100],
            connect: true,
            range: {
                'min': 0,
                'max': 100 // TODO: UPDATE TO DYNAMIC HIGHEST PRICE
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
        noUiSlider.create(stockSlider, {
            start: [0, 1000],
            connect: true,
            range: {
                'min': 0,
                'max': 1000 // TODO: UPDATE TO DYNAMIC HIGHEST STOCK
            },
            step: 10
        });
        
        stockSlider.noUiSlider.on('update', function (values) {
            document.getElementById('min-stock').textContent = Math.round(values[0]);
            document.getElementById('max-stock').textContent = Math.round(values[1]);
            
            document.getElementById('min_stock_input').value = Math.round(values[0]);
            document.getElementById('max_stockinput').value = Math.round(values[1]);
        });
    }
});