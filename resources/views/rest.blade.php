<script>
    $(document).ready(function() {
        $("#createPost").submit(function(event) {
            event.preventDefault();
            $.ajax({
                method: "Post",
                data: $(this).serialize(),
                url: "{{ route('posts.store') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                {
                    "Authorization": localStorage.getItem('token')
                }

                success: function(response) {
                    $('#height-ad').show();
                }
            });
        });
    });
</script>






<div class="form signup">
    <div class="form-content">
        <header>Signup</header>
        <form id="registration">
            @csrf
            <div class="field input-field">
                <input type="text" placeholder="Username" name="name" class="input" required>
            </div>
            <div class="field input-field">
                <input type="email" name="email" placeholder="Email" class="input" required>
            </div>

            <div class="field input-field">
                <input type="password" name="password" placeholder="Create password" class="password" required>
                <i class='bx bx-hide eye-icon'></i>

            </div>

            <div class="field input-field">
                <input type="password" name="password_confirmation" placeholder="Confirm password"
                    class="password" required>
            </div>

            <div class="field button-field">
                <button>Signup</button>
            </div>
        </form>

        <div class="form-link">
            <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#registration").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    method: "Post",
                    data: $(this).serialize(),
                    url: "{{ url('api/register') }}",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        $('#height-ad').show();
                    }
                });
            });
        });
    </script>
</div>




{{-- new --}}
<script>
$(document).ready(function() {
    $('#login-form').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '/api/login',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                const token = response.token;


                localStorage.setItem('access_token', token);


                $('#create-post-section').show();

                $('#login-form').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Login error:', errorThrown);

            }
        });
    });


        $.ajax({
            url: '/api/',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function(response) {

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('API request error:', errorThrown);

            }
        });
    });
});
</script>

{{-- old --}}


$(document).ready(function()
{
   $("#myForm").submit(function(event) {
       event.preventDefault();

       var formData = {
           email: $("#email").val(),
           password: $("#password").val()
       };

       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

       $.ajax({
           type: "POST",
           url: "{{ url('api/login') }}",
           data: formData,
           dataType: 'json',
           success: function(response) {

               var access_token = response.token;
               localStorage.setItem('access_token', access_token);

               $(".form .login").hide();
               $("#height-ad").show();
// links.forEach(link => {
//     link.addEventListener("click", e => {
//        e.preventDefault();
//        forms.classList.toggle("height-ad");
//     })
// })

           },
           error: function(error) {
               $("#message").text("Failed to save data.");
           }
       });
   });
});


{{-- register --}}
<script>
    $(document).ready(function() {
        $("#myotherForm").submit(function(event) {
            event.preventDefault();

            var formData = {
                name: $("#name").val(),
                email: $("#emaill").val(),
                password: $("#passwordd").val()
                password_confirmation: $("#password_confirmation").val()
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('api/register') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {


                    document.open();
                   document.write(response);
                   document.close();

                    $(".form .login").hide();
                    $("#height-ad").show();
// links.forEach(link => {
//     link.addEventListener("click", e => {
//        e.preventDefault();
//        forms.classList.toggle("height-ad");
//     })
// })
},
                error: function(error) {
                    $("#message").text("Failed to save data.");
                }
            });
        });
    });
</script>



 {{-- <li class="nav-item fw-bold">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item fw-bold">
                        <a class="nav-link" href="#height-ad">Create</a>
                    </li> --}}




                    {{-- fetch --}}

                    <script>

                        $(document).ready(function() {
                        function fetchPosts() {
                        $.ajax({
                            url: "{{route('posts.index')}}",

                            method: 'GET',
                            dataType: 'json',
                            headers: {"Authorization": "Bearer " + localStorage.getItem('authToken')},
                            success: function(data) {
                                var html = '';
                                $.each(data, function(index, post) {
                                    html += '<tr>';
                                    html += '<td>' + post.title + '</td>';
                                    html += '<td>' + post.description + '</td>';
                                    html += '<td>  <button class="editButton btn btn-success" data-id="' + post.id + '">Edit</button></td>';
                                    html += '<td>  <button class="deleteButton btn btn-danger" data-id="' + post.id + '">Delete</button></td>';
                                    html += '</tr>';
                                });
                                $('#postTable tbody').html(html);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                    fetchPosts();
                });
                    </script>




{{-- my create and make post form  --}}

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
                description: $("#description").val()
            };

            $.ajax({
                type: "POST",
                url: "{{ route('posts.store') }}",
                data: formData,
                dataType: 'json',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('authToken')
                },

                success: function(response) {

                    $("#title").val("");
                    $("#description").val("");


                    $("#message").text("Data saved successfully!");
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
