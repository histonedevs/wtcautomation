<div class="form-group div_products">
    <label for="products" class="control-label">Products</label>
    <select class="form-control"  id="products" name="products">
        @foreach($products as $product)
            <option value='{{$product->id}}' >{{$product->asin}} -&gt; {{$product->title}} </option>
        @endforeach
    </select>
</div>