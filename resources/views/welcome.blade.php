<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark fixed-top" aria-label="Twelfth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://w7.pngwing.com/pngs/380/764/png-transparent-paper-box-computer-icons-symbol-random-icons-miscellaneous-angle-text-thumbnail.png"
                    alt="Logo" width="50" height="50" id="main-logo" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10"
                aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
                <ul class="navbar-nav">

                </ul>

            </div>
            <button id="btn-logout" class="btn btn-outline-danger" type="button">Logout</button>

    </nav>

    <section id="height-ad">

        <div class="container lg p-3">
            <div class="row">
                <div class="col-md-4">
                    <div id="to-hide" class="card" style="width:30rem;">
                        <div class="card-header">
                            <h4 class="text-center">Add post</h4>
                        </div>
                        <form id="myForm">
                            @csrf
                            <input type="hidden" id="post_id" name="post_id"> <!-- Add this line -->

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Title:</label>
                                    <input type="text" class="form-control" id="title" placeholder="Enter title"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="">Description:</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Ener description" id="description" required>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary float-right">Save</button>
                                </div>
                        </form>
                        <div class="w-100">
                            <span id="message" class="text-success"></span>
                        </div>
                    </div>
                </div>

            </div>
            <br>
        </div>
        <table id="postTable" class="table table-bordered text-white text-center">
            <thead>
                <th>Title</th>
                <th>Description</th>
                <th>Edit</th>
                <script>
                    $(document).on("click", ".editButton", function() {
                        var postId = $(this).data("id");

                        $.ajax({
                            url: "api/posts/" + postId + "/edit",
                            method: 'GET',
                            headers: {
                                'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(data) {
                                $('#title').val(data.title);
                                $('#description').val(data.description);
                                $('#post_id').val(data.id);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error: " + error);
                            }
                        });
                    });
                </script>
                <th>Delete</th>
                <script>
                    $(document).on("click", ".deleteButton", function() {
                        var postId = $(this).data("id");
                        var $button = $(this);

                        $.ajax({
                            url: "api/posts/" + postId,
                            method: 'DELETE',
                            data: {
                                post_id: postId
                            },
                            headers: {
                                "Authorization": "Bearer " + localStorage.getItem('authToken'),
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $button.closest("tr").remove();
                                console.log("Post deleted .");
                            },
                            error: function(xhr, status, error) {
                                console.error("Error : " + error);
                            }
                        });
                    });
                </script>


            </thead>
            <tbody id="tbody">
                {{-- my all data will be here --}}
            </tbody>
        </table>



        </div>
        <script>
            function fetchPosts() {
                $.ajax({
                    url: "{{ route('posts.index') }}",
                    method: 'GET',
                    dataType: 'json',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem('authToken')
                    },
                    success: function(data) {
                        var html = '';
                        $.each(data, function(index, post) {
                            html += '<tr>';
                            html += '<td>' + post.title + '</td>';
                            html += '<td>' + post.description + '</td>';
                            html += '<td>  <button class="editButton btn btn-success" data-id="' + post.id +
                                '">Edit</button></td>';
                            html += '<td>  <button class="deleteButton btn btn-danger" data-id="' + post
                                .id + '">Delete</button></td>';
                            html += '</tr>';
                        });
                        $('#postTable tbody').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            $(document).ready(function() {
    fetchPosts();

    $("#myForm").submit(function(event) {
        event.preventDefault();

        var formData = {
            title: $("#title").val(),
            description: $("#description").val(),
            post_id: $("#post_id").val()
        };

        $.ajax({
            type: formData.post_id ? "PUT" : "POST",
            url: formData.post_id ? "{{ route('posts.update', '') }}" + "/" + formData.post_id : "{{ route('posts.store') }}",
            data: formData,
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('authToken')
            },
            success: function(response) {
                $("#title").val("");
                $("#description").val("");
                $("#post_id").val("");

                if (formData.post_id) {
                    $("#message").text("Post updated !");
                } else {
                    $("#message").text("Post created !");
                }

                setTimeout(function() {
                    $("#message").text("");
                }, 3000);

                fetchPosts();
            },
            error: function(error) {
                $("#message").text("Failed to save data.");
                setTimeout(function() {
                    $("#message").text("");
                }, 3000);
            }
        });
    });
});

        </script>

    </section>
    <section class="container forms">
        <div id="form-login" class="form login">
            <div class="form-content">
                <header>Login</header>
                <form action="#">
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button>Login</button>
                    </div>
                </form>
                <div id="response"></div>
                <div class="form-link">
                    <span>Don't have an account? <a href="#" class="link signup-link">Signup</a></span>
                </div>
                <div class="w-100">
                    <span id="response" class="text-success"></span>
                </div>
            </div>
        </div>

        <!-- Signup Form -->

        <div class="form signup">
            <div class="form-content">
                <header>Signup</header>
                <form action="#">
                    <div class="field input-field">
                        <input type="text" id="name" placeholder="Username" class="input" required>
                    </div>

                    <div class="field input-field">
                        <input type="email" id="email" placeholder="Email" class="input"required>
                    </div>

                    <div class="field input-field">
                        <input type="password" id="password" placeholder="Create password" class="password"
                            required>
                    </div>

                    <div class="field input-field">
                        <input type="password" id="password-confirm" placeholder="Confirm password" class="password"
                            required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <button id="btn-signup">Signup</button>
                    </div>
                </form>
                <script>
                    $(document).ready(function() {
                        $("#btn-signup").click(function(event) {
                            event.preventDefault();

                            var formData = {
                                name: $("#name").val(),
                                email: $("#email").val(),
                                password: $("#password").val(),
                                password_confirmation: $("#password-confirm").val(),
                            };
                            $.ajax({
                                type: "POST",
                                url: "{{ route('register') }}",
                                data: formData,
                                dataType: 'json',
                                success: function(response) {

                                    $("#name").val("");
                                    $("#email").val("");
                                    $("#password").val("");
                                    $("#password-confirm").val("");

                                    $("#messages").text("Registration successful!");



                                    $('#form-login').show();
                                },
                                error: function(xhr, status, error) {

                                    $("#messages").text("Failed to register.");
                                }
                            });
                        });
                    });
                </script>

                <div class="form-link">
                    <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
                </div>
                <span id="message"></span>
            </div>
        </div>

    </section>


    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script>
        function toggleElements(authenticated) {
            if (authenticated) {
                $('.form.login').hide();
                $('.form.login').hide();
                $('#height-ad').show();
                $('#btn-logout').show();
            } else {
                $('.form.login').show();
                $('.form.signup').show();
                $('#height-ad').hide();
                $('#btn-logout').hide();
            }
        }

        function handleLogin() {
            var email = $('.form.login .input[type="email"]').val();
            var password = $('.form.login .password').val();

            $.ajax({
                url: "{{ url('api/login') }}",
                method: 'POST',
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response && response.access_token) {
                        var token = response.access_token;
                        localStorage.setItem('authToken', token);
                        toggleElements(true);
                        checkAuthentication();
                    } else {
                        $("#response").text("Failed to log in.");
                    }
                },
                error: function(error) {
                    console.error(error);
                    $("#response").text("An error occurred.");
                }
            });
        }

        function displayErrorMessage(message) {
            var errorMessageElement = $('#response');
            errorMessageElement.text(message);
            errorMessageElement.show();
        }

        function handleLogout() {
            $.ajax({
                url: 'api/logout',
                method: 'POST',
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('authToken')
                },
                success: function(response) {

                    localStorage.removeItem('authToken');
                    toggleElements(false);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            var authToken = localStorage.getItem('authToken');
            if (authToken) {
                toggleElements(true);
            } else {
                toggleElements(false);
            }
        });
        $('.form.login form').submit(function(event) {
            event.preventDefault();
            handleLogin();
        });
        $('#btn-logout').click(function() {
            handleLogout();
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
