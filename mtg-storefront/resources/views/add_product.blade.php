<form method="POST" action="/products">
    <select name="category_id" id="category_select">
        <option value="1">Singles</option>
        <option value="2">Sealed</option>
        <option value="3">Accessories</option>
    </select>

    <!-- always visible -->
    <input type="text" name="product_name" />
    <input type="number" name="price" />
    <input type="number" name="stock" />

    <!-- only shows when sealed is selected -->
    <div id="sealed_fields" style="display:none">
        <input type="text" name="set_name" />
    </div>

    <!-- only shows when singles is selected -->
    <div id="singles_fields" style="display:none">
        <input type="text" name="rarity" />
        <input type="text" name="color" />
        <input type="text" name="number" />
    </div>

    <!-- only shows when accessories is selected -->
    <div id="accessories_fields" style="display:none">
        <input type="text" name="product_type" />
    </div>
</form>

<script>
    document.getElementById('category_select').addEventListener('change', function() {
        document.getElementById('sealed_fields').style.display = 'none';
        document.getElementById('singles_fields').style.display = 'none';
        document.getElementById('accessories_fields').style.display = 'none';

        if (this.value == 2) document.getElementById('sealed_fields').style.display = 'block';
        if (this.value == 1) document.getElementById('singles_fields').style.display = 'block';
        if (this.value == 3) document.getElementById('accessories_fields').style.display = 'block';
    });
</script>