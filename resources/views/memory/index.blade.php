<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Photomem</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>

<div class="container mt-2">

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Photomem</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('memory.create') }}"> Create New Post</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($memory as $mem)
        <tr>
            <td>{{ $mem->id }}</td>
            <td><img src="{{ Storage::url($mem->image) }}" height="75" width="75" alt="" /></td>
            <td>{{ $mem->title }}</td>
            <td>{{ $mem->description }}</td>
            <td>
                <form action="{{ route('memory.destroy',$mem->id) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('memory.edit',$mem->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $memory->links() !!}

</body>
</html>
