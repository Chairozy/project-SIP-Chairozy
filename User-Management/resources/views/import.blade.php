<form action="{{ route('excel.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel">
    <input type="submit" value="Import">
</form>