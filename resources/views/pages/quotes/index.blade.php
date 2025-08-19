@extends('layouts.main')

<title>LIST SEWA | Quotes</title>

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Manage Quoutes</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quotes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    {{-- <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">(834)</span></h5> --}}
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <table id="quotes" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Messages</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotes as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$item->user->name}}</td>
                                <td>
                                    <span class="short-message">{{ Str::limit($item->messages, 30) }}</span>
                                    <span class="full-message d-none">{{ $item->messages }}</span>
                                    <a href="javascript:void(0);" class="toggle-message" data-id="{{ $item->id }}">Show more</a>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editTypeContractModal" data-id="{{ $item->id }}" data-messages="{{ $item->messages }}">
                                        <i class="fa fa-pen"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTypeContractModal" data-id="{{ $item->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('quotes.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <textarea name="messages" class="form-control" id="messages" cols="30" rows="10"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


        <!-- Edit Modal -->
        <div class="modal fade" id="editTypeContractModal" tabindex="-1" aria-labelledby="editTypeContractModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" id="editRegionForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTypeContractModalLabel">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_messages" class="form-label">DC</label>
                                <textarea name="messages" class="form-control" id="edit_messages" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteTypeContractModal" tabindex="-1" aria-labelledby="deleteTypeContractModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="deleteQuoteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteTypeContractModalLabel">Delete Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this quote?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#quotes').DataTable(); 

            $('.toggle-message').on('click', function() {
                var $this = $(this);
                var id = $this.data('id');
                var $shortMessage = $this.closest('td').find('.short-message');
                var $fullMessage = $this.closest('td').find('.full-message');

                if ($fullMessage.hasClass('d-none')) {
                    // Show full message
                    $shortMessage.addClass('d-none');
                    $fullMessage.removeClass('d-none');
                    $this.text('Show less');
                } else {
                    // Show short message
                    $shortMessage.removeClass('d-none');
                    $fullMessage.addClass('d-none');
                    $this.text('Show more');
                }
            });

            $('#editTypeContractModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var messages = button.data('messages');

                var modal = $(this);
                modal.find('.modal-body textarea[name="messages"]').val(messages);
                modal.find('form').attr('action', '/quotes/' + id);
            });

            $('#deleteTypeContractModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                var modal = $(this);
                modal.find('form').attr('action', '/quotes/' + id); 
            });
            
        });
    </script>
@endsection