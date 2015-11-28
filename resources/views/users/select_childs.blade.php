<div class="form-group div_child_users">
    <label for="child_users" class="control-label">Child Users</label>
    <select class="form-control" id="child_users" name="child_users">
        <option>Select Child Users</option>
        <option value="{{ $userParent->id }}">{{ $userParent->name }}</option>
        @foreach($child_users as $child_user)
            <option value='{{$child_user->id}}'> {{$child_user->account_title}} </option>
        @endforeach
    </select>
</div>