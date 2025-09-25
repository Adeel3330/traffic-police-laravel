<!DOCTYPE html>
<html>
<head>
    @include('include.head')
    <style>
        html, body {
            height: 100%; /* Full height for flex layout */
            margin: 0;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full viewport height */
        }

        .content {
            flex: 1; /* Take up all available space */
        }

        input {
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">

        @include('include.header')

        <div class="container content">
            <h1 class="mt-5">Upload CSV or Excel File</h1>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('storage.upload') }}" method="POST" enctype="multipart/form-data" class="mb-3 w-100">
                @csrf
                <input type="file" name="file" class="form-control form-control-lg mb-3" accept=".csv, .xls, .xlsx" required>
                <button class="btn btn-primary btn-lg">Upload</button>
            </form>
        </div>

        @include('include.footer')

    </div>
</body>
</html>