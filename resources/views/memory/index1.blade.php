<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Photomem</title>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"></head>
<body>

<div class="container">

<div class="row">
        <div class="col margin-tb">
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

    {{-- <div class="card-columns"> --}}
        @foreach ($memory as $mem)
            {{-- @if (($loop->index % 3 == 0) && ($loop->index == 0))
                <div class="card-group">
            @endif --}}
                    <div class="card" style="">
                        <img class="card-img-top" src="{{ Storage::url($mem->image) }}" alt="Card image cap">
                        <div class="card-body">
                            <span>
                                @foreach ($mem->tags as $tag)
                                <span class="badge badge-secondary">{{$tag->name}}</span>
                                @endforeach
                            </span>
                            <h5 class="card-title">{{ $mem->title }}</h5>
                            <p class="card-text">{{ $mem->description }}</p>
                            <form action="{{ route('memory.destroy',$mem->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('memory.edit',$mem->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>

                {{-- @if (($loop->index % 3 == 0) && ($loop->index == 0))
            </div>
            @endif --}}
            @endforeach
        </div>
        </div>

    {{-- <table class="table table-bordered">
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
            @foreach ($mem->tags as $tag)
                <span class="badge badge-secondary">{{$tag->name}}</span>

                @endforeach
            </td>
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
    </table> --}}

    {{-- {!! $memory->links() !!} --}}

</body>
</html>
