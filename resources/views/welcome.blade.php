<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Ajax Crud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="container mt-3">

        <div class="mb-3">
            <h2>Todo App</h2>
        </div>

       <div class="mb-2">
            <button type="button" class="btn btn-primary" id="add_todo_button">
                Add Todo
            </button>
       </div>

        <table class="table table-bordered">
            <thead>
                <th class="col-md-1 text-center">ID</th>
                <th class="col text-center">Todo name</th>
                <th class="col-md-2 text-center">Actions</th>
            </thead>
            <tbody id="list_todo">
                @foreach ($todos as $todo)
                    <tr id="row_todo_{{ $todo->id }}">
                        <td class="text-center">{{ $todo->id }}</td>
                        <td>{{ $todo->name }}</td>
                        <td class="text-center">
                            <button id="edit_todo" data-id="{{ $todo->id }}"
                                class="btn btn-sm btn-primary mx-1">Edit</button>
                            <button id="delete_todo" data-id="{{ $todo->id }}"
                                class="btn btn-sm btn-danger me-1">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="todo_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_title"></h1>
                    </div>
                    <form id="form_todo" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="id" id="id">
                            <label for="name_todo" class="form-label">Enter Todo :</label>
                            <input type="text" name="name" id="name_todo" class="form-control">

                        </div>
                        <div class="modal-footer px-1">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


        $("#add_todo_button").on('click', function() {
            $("#form_todo").trigger('reset');
            $("#form_todo")[0].reset();
            $("#modal_title").html('Add Todo');
            $("#todo_modal").modal('show');
        });

        $('body').on('click', '#edit_todo', function() {
            var id = $(this).data('id')

            $.get('todos/' + id + '/edit', function(res) {
                $("#modal_title").html('Edit Todo');
                $("#id").val(res.id);
                $("#name_todo").val(res.name);
                $("#todo_modal").modal('show');
            });
        });

        // Create & Edit
        $("form").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "todos/store",
                data: $("#form_todo").serialize(),
                type: 'POST'
            }).done(function(res) {
                var row = '<tr id="row_todo_' + res.id + '">';
                row += '<td class="text-center">' + res.id + '</td>';
                row += '<td>' + res.name + '</td>';
                row += '<td class="text-center"><button id="edit_todo" data-id="' + res.id +
                    '"class="btn btn-sm btn-primary mx-1">Edit</button>';
                row += '<button id="delete_todo" data-id="' + res.id +
                    '" class="btn btn-sm btn-danger mx-1">Delete</button></td>';
                row += '</tr>';

                if ($('#id').val()) {
                    $('#row_todo_' + res.id).replaceWith(row);
                } else {
                    $('#list_todo').prepend(row);
                }

                $('#form_todo').trigger('reset');
                $('#todo_modal').modal('hide');

            });
        });

        // Delete Todo
        $('body').on('click', '#delete_todo', function() {
            var id = $(this).data('id')
            confirm('Are you sure want to delete this todo ?');

            $.ajax({
                type: 'DELETE',
                url: "todos/destroy/" + id
            }).done(function(res) {
                $('#row_todo_' + id).remove();
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
