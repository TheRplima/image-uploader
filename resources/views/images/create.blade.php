<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Dropzone -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('css/style.css') }}" type="text/css" />
</head>

<body>
    <div class="container mt-4 mb-5 pb-3">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="text-center header">
                    <h2 class="mb-5">Upload your image</h2>
                    <p class="mb-4">files should be jpeg, png, svg</p>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('images.store') }}" enctype="multipart/form-data" class="dropzone mb-4"
            id="dropzone">
            @csrf
            <div class="dz-message">
                <img src="{{ asset('assets/image.svg') }}" />
                <p class="note mt-5">Drag & Drop your image here</p>
            </div>
        </form>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="text-center">
                    <p class="note mb-3">Or</p>
                    <p><button class="btn btn-primary choose-file">Choose a file</button></p>
                </div>
            </div>
        </div>
    </div>

    <div id="preview-template" style="display: none;">
        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail=""></div>
            <div class="dz-details">
                <div class="dz-size"><span data-dz-size=""></span></div>
                <div class="dz-filename"><span data-dz-name=""></span></div>
            </div>
            <div class="progress-container">
                <div class="progress-box">
                    <h2 class="p-5">Uploading...</h2>
                    <div class="dz-progress">
                        <div class="dz-upload progress-bar progress-bar-primary" role="progressbar" data-dz-uploadprogress>
                            <span class="progress-text"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
        </div>
    </div>

    <footer class="fixed-bottom py-2 text-center bg-white">
        Created by <a href="https://devchallenges.io/portfolio/TheRplima" target="_blank">TheRplima</a> - <a href="https://devchallenges.io/" target="_blank">devchallenges.io</a>
    </footer>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Dropzone -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <!-- Bootstrap CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        Dropzone.options.dropzone = {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            maxFiles: 1,
            parallelUploads: 1,
            maxFilesize: 12,
            resizeQuality: 1.0,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
            addRemoveLinks: true,
            filesizeBase: 1000,
            paramName: "image",
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            },
            removedfile: function(file, response) {
                let id = $(file.previewElement.querySelector("[data-dz-thumbnail]")).attr('data-image-id');
                if (id !== undefined) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        type: 'DELETE',
                        url: "{{ url('images/') }}/" + id,
                        data: {
                            noredir: 1
                        },
                        success: function(data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                }
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            maxfilesexceeded: function(file) {
                this.removeFile(file);
                alert('You can upload only 1 image!')
            },
            success: function(file, response) {
                // console.log(response)
                let data = JSON.parse(response.data);
                let thumb = file.previewElement.querySelector("[data-dz-thumbnail]");
                $(thumb).attr('data-image-id', data.id)
                // $(file.previewElement.querySelector(".progress-container")).css('display','none');
                window.location.href = "{{ url('images/') }}/" + data.id;
            },
            error: function(file, response) {
                return false;
            }
        };

        $('.choose-file').on('click', (e) => {
            document.getElementsByClassName('dropzone')[0].click();
        });
    </script>
</body>

</html>
