<form role="form" method="POST" action="{{ url('auth/login') }}">
    {!! csrf_field() !!}
    <h3>Fill in the credentials</h3>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-default" id="submit" name="submit">Login</button>

</form>