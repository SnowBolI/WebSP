<x-guest-layout>
    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <style>
        /* Gaya khusus untuk latar belakang gelap */
        .dark-bg {
            background-color: #1a202c !important; /* Warna latar belakang gelap */
            color: #e2e8f0 !important; /* Warna teks putih */
        }

        /* Gaya khusus untuk input, select, dan button */
        .dark-bg input[type=text],
        .dark-bg input[type=email],
        .dark-bg input[type=password],
        .dark-bg select,
        .dark-bg button {
            background-color: #2d3748;
            color: #cbd5e0;
            border-color: #4a5568;
        }

        .dark-bg input[type=text]:focus,
        .dark-bg input[type=email]:focus,
        .dark-bg input[type=password]:focus,
        .dark-bg select:focus,
        .dark-bg button:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        .dark-bg .img-container {
            background-color: #2d3748;
            border: 1px solid #4a5568;
        }
        
        /* Styling for cropping area */
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }

        .preview-container {
            margin-top: 20px;
            display: none;
        }

        .preview-image {
            border-radius: 50%;
            border: 2px solid #4a5568;
        }
    </style>

    <div class="min-h-screen flex flex-col items-center justify-center dark-bg">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="w-full max-w-md p-6 rounded-lg">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full dark-bg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full dark-bg" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full dark-bg"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full dark-bg"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Jabatan -->
            <div class="mt-4">
                <x-input-label for="jabatan_id" :value="__('Jabatan')" />
                <select id="jabatan_id" name="jabatan_id" class="block mt-1 w-full dark-bg focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Models\Jabatan::all() as $jabatan)
                        <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->nama_jabatan }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jabatan_id')" class="mt-2" />
            </div>

            <!-- Form untuk Pemilihan Cabang -->
            <div id="form-cabang" class="mt-4" style="display: none;">
                <x-input-label for="cabang_id" :value="__('Cabang')" />
                <select id="cabang_id" name="cabang_id" class="block mt-1 w-full dark-bg focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('cabang_id')" class="mt-2" />
            </div>

            <!-- Input Gambar -->
            <div class="mt-4">
                <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="block mt-1 w-full dark-bg" />
                <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
            </div>

            <!-- Preview Cropped Image -->
            <div class="preview-container">
                <x-input-label :value="__('Cropped Image Preview')" />
                <img id="cropped_image_preview" class="preview-image mt-4" style="max-width: 100px; max-height: 100px;" />
            </div>

            <input type="hidden" id="cropped_image" name="cropped_image">

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4 dark-bg hover:bg-indigo-700">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content dark-bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image" style="max-width: 100%;" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop_button" class="btn btn-primary dark-bg">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        $(document).ready(function () {
            var cropper;
            var image = document.getElementById('image');

            $('#profile_picture').on('change', function (e) {
                var files = e.target.files;
                var done = function (url) {
                    image.src = url;
                    $('#cropModal').modal('show');
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        cropBoxResizable: true,
                        cropBoxMovable: true,
                        guides: false,
                        highlight: false,
                        autoCropArea: 1,
                        background: false,
                        responsive: true,
                        rotatable: false,
                        scalable: false,
                        zoomable: false,
                    });
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $('#crop_button').on('click', function () {
                if (cropper) {
                    var canvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 300,
                    });

                    // Creating a circular crop
                    var diameter = Math.min(canvas.width, canvas.height);
                    var croppedCanvas = document.createElement('canvas');
                    var croppedContext = croppedCanvas.getContext('2d');

                    croppedCanvas.width = diameter;
                    croppedCanvas.height = diameter;

                    croppedContext.beginPath();
                    croppedContext.arc(diameter / 2, diameter / 2, diameter / 2, 0, 2 * Math.PI);
                    croppedContext.clip();
                    croppedContext.drawImage(canvas, (diameter - canvas.width) / 2, (diameter - canvas.height) / 2);

                    croppedCanvas.toBlob(function (blob) {
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function () {
                            var base64data = reader.result;
                            $('#cropped_image').val(base64data);
                            $('#cropped_image_preview').attr('src', base64data);
                            $('.preview-container').show();
                            $('#cropModal').modal('hide');
                        };
                    });
                }
            });
        });
    </script>
</x-guest-layout>
