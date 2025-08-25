@extends('layouts.main')

<title>LAPORAN | IMX</title>

<style>
    #spkResults {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
</style>

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h4>LAPORAN</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="">PILIH BERDSARKAN </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="category_id"></label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="{{ null }}">All</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col mt-2">
                            <button id="exportButtonReport" class="btn btn-primary">
                                <i class="fa fa-file-excel"></i> EXPORT
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#exportButtonReport').on('click', function() {
                const category = $('#category_id').val();

                window.location.href = `/laporan/export?category=${category}`;
            });
        });
    </script>
@endsection
