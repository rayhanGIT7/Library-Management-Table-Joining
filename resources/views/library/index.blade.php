<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



<div style="width: 500px; margin-left:440px; margin-top:100px;">
<form action="{{ route('book_info.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="text" id="searchInput" placeholder="Search by name..." class="form-control">
            <div id="searchResults"></div>
            <input type="text" id="user_id" name="user_id">
        </div>


        <div class="mb-3">
            <label for="genre" class="form-label">Book Category</label>
            <select id="category_id" class="form-select">
                <option disabled selected>Select Category</option>
                @foreach ($book_categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="name" class="form-label">Book</label>
            <input type="text" value="" id="searchBook" placeholder="Search by name..." class="form-control">

            <input type="text" id="book_id" name="book_id">
            <div id="BookResults"></div>
        </div>

        <div class="mb-3">
            <label for="return_date" class="form-label">Receive Date: </label>
            <input type="date" id="receive_date" name="receive_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="receive_date" class="form-label">Return Date:</label>
            <input type="date" id="return_date" name="return_date" class="form-control">
        </div>



        <button type="submit" class="btn btn-success">Create Book</button>
    </form>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    // search by user name
    $(document).ready(function() {
        $("#searchInput").on('keyup', function() {
            let data = $(this).val();
            $('#searchInput').val(data);
            if (data.trim() !== '') {
                $.ajax({
                    url: "{{ route('searchByName') }}",
                    type: "GET",
                    data: {
                        'name': data
                    },
                    success: function(response) {
                        var html = "";
                        response.forEach(function(user) {
                            html += "<div><li id='" + user.id + "'>" + user.name + "</li></div>";
                        });
                        $('#searchResults').html(html);
                    }


                });
            } else {
                $('#searchResults').html("");
            }
        });
        $(document).on('click', '#searchResults li', function() {
            let data = $(this).text();
            let id = $(this).attr('id');
            console.log(id);
            $('#user_id').val(id);
            $('#searchInput').val(data);
            $('#searchResults').html("");
        });


    });


    // search by book

    $(document).ready(function() {
        $("#searchBook").on('keyup', function() {
            let bookName = $(this).val().trim();
            let categoryId = $("#category_id").val();
            if (bookName !== '') {
                fetchBookSuggestions(bookName, categoryId);
            } else {
                $('#BookResults').html("");
            }
        });

        $("#category_id").change(function() {
            let bookName = $("#searchBook").val().trim();
            let categoryId = $(this).val();
            if (bookName !== '') {
                fetchBookSuggestions(bookName, categoryId);
            } else {
                $('#BookResults').html("");
            }
        });

        function fetchBookSuggestions(bookName, categoryId) {
            $.ajax({
                url: "{{ route('searchByBook') }}",
                type: "GET",
                data: {
                    'name': bookName,
                    'category_id': categoryId
                },
                success: function(response) {
                    renderBookResults(response);
                }
            });
        }

        function renderBookResults(books) {

            let html = '';
            books.forEach(function(book) {

                html += "<div><li id='" + book.id + "'>" + book.title + '-' + book.author_name + '-' + book.publication_year +  "</li></div>";
            });
            $('#BookResults').html(html);
        }

        $(document).on('click', '#BookResults div li', function() {
            let data = $(this).text();
            let id = $(this).attr('id');
            console.log(id);
            $('#book_id').val(id);
            $('#searchBook').val(data);
            $('#BookResults').html("");
        });

    });

</script>
