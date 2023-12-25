<a href="{{ route('company.edit', $id) }}" class="btn btn-primary btn-sm">Edit</a>
<form action="{{ route('company.destroy', $id) }}" method="post" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm bg-danger">Delete</button>
</form>
