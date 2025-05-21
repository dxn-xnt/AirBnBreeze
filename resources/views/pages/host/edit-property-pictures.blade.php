@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <!-- Photo Upload Section -->
        <form id="picturesForm" action="{{ route('property.update.pictures', ['property' => $property->prop_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden field to determine which button was clicked -->
            <input type="hidden" name="form_action" id="form_action" value="">

            <div class="px-[8%]">
                <div class="flex justify-between mb-3">
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Listing Editor
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ route('host.listing') }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-light">
                            Back
                        </a>
                        <button type="submit" name="save_and_exit" onclick="setFormAction('save_and_exit')" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                            Save & Exit
                        </button>
                    </div>
                </div>

                <div class="flex justify-start gap-3 pt-5">
                    <a href="{{ route('property.edit.type', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Property Type</a>
                    <a href="{{ route('property.edit.location', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Location</a>
                    <a href="{{ route('property.edit.capacity', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Capacity</a>
                    <a href="{{ route('property.edit.description', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Description</a>
                    <a href="{{ route('property.edit.amenities', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Amenities</a>
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md px-8 py-8">
                <h3 class="text-xl font-medium text-gray-900 mb-2">Add some photos of your house</h3>

                @php
                    // Get all image data
                    $draftData = session()->get('property_draft', []);
                    $storedImages = $propertyImages->pluck('img_url')->toArray();
                    $newUploads = $draftData['images'] ?? [];
                    $removedImages = $draftData['removed_images'] ?? [];

                    // Combine and filter images
                    $allImages = array_unique(array_merge($storedImages, $newUploads));
                    $displayImages = array_diff($allImages, $removedImages);

                @endphp

                    <!-- File Input Area -->
                <div class="border-2 border-dashed border-airbnb-darkest rounded-xl px-6 py-6 text-center mb-4 min-h-72">
                    <!-- Image Thumbnails Grid -->

                    <div id="image-thumbnails" class="grid grid-cols-3 gap-4 mb-4">
                        @if(count($displayImages) > 0)
                            @foreach($displayImages as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image) }}"
                                         alt="Property image"
                                         class="w-full h-32 object-cover rounded-sm border border-airbnb-darkest">
                                    <button type="button"
                                            onclick="markImageForRemoval('{{ $image }}')"
                                            class="absolute top-1 right-1 bg-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p class="col-span-3 text-center text-gray-500">No images uploaded yet</p>
                        @endif
                    </div>

                    <!-- Upload Button -->
                    <div class="flex flex-col items-center justify-center mt-2 text-sm text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-dark-red hover:text-indigo-500 focus-within:outline-none flex flex-col items-center">
                            <svg class="w-8 h-8 mb-2 text-dark-red" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-center">Upload photos</span>
                            <input id="file-upload" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                        </label>
                        <p class="text-xs text-airbnb-darkest mt-1">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>

                <!-- General Error Message -->
                @if($errors->any())
                    <div class="mt-2 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="flex gap-3 max-w-screen-xl justify-end">
                <button type="submit" name="save_draft" onclick="setFormAction('save_draft')" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
                    Save
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Function to set form action
            function setFormAction(action) {
                document.getElementById('form_action').value = action;
            }

            // Function to mark image for removal (draft mode only)
            function markImageForRemoval(imagePath) {
                if (confirm('This image will be removed when you click Save & Exit. Continue?')) {
                    fetch("{{ route('property.mark.image.removal', ['property' => $property->prop_id]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            image_path: imagePath
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hide the image immediately (but don't actually delete yet)
                                const images = document.querySelectorAll('#image-thumbnails img');
                                images.forEach(img => {
                                    if (img.src.includes(imagePath)) {
                                        img.closest('.relative').remove();
                                    }
                                });

                                // Show message
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Image marked for removal. It will be deleted when you click Save & Exit.',
                                        type: 'success'
                                    }
                                });
                                document.dispatchEvent(event);

                                // Reload if no images left
                                if (document.querySelectorAll('#image-thumbnails .relative').length === 0) {
                                    document.getElementById('image-thumbnails').innerHTML =
                                        '<p class="col-span-3 text-center text-gray-500">No images uploaded yet</p>';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const event = new CustomEvent('show-toast', {
                                detail: {
                                    message: 'Error marking image for removal',
                                    type: 'error'
                                }
                            });
                            document.dispatchEvent(event);
                        });
                }
            }

            // Handle form submission with AJAX
            document.getElementById('picturesForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const action = formData.get('form_action');

                // Determine the endpoint based on action
                const endpoint = action === 'save_and_exit'
                    ? "{{ route('property.save.all.updates', ['property' => $property->prop_id]) }}"
                    : form.action;

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (action === 'save_and_exit') {
                                // Redirect to property page or listings page
                                window.location.href = data.redirect || "{{ route('host.listing') }}";
                            } else {
                                // Show success message for draft save
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Images saved to draft',
                                        type: 'success'
                                    }
                                });
                                document.dispatchEvent(event);
                                // Reload to show updated images
                                window.location.reload();
                            }
                        } else {
                            // Show error message
                            const event = new CustomEvent('show-toast', {
                                detail: {
                                    message: data.message || 'Error saving images',
                                    type: 'error'
                                }
                            });
                            document.dispatchEvent(event);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const event = new CustomEvent('show-toast', {
                            detail: {
                                message: 'An error occurred while saving',
                                type: 'error'
                            }
                        });
                        document.dispatchEvent(event);
                    });
            });

            // Function to remove an image
            function removeImage(imagePath, index) {
                if (confirm('Are you sure you want to remove this image?')) {
                    // Properly encode the image path for the URL
                    const encodedImagePath = encodeURIComponent(imagePath);

                    // Construct the URL with both parameters
                    const url = `/host/property/${encodeURIComponent({{ $property->prop_id }})}/view-edit/pictures/${encodedImagePath}`;

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ index: index })
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const event = new CustomEvent('show-toast', {
                                    detail: {
                                        message: 'Image removed successfully',
                                        type: 'success'
                                    }
                                });
                                document.dispatchEvent(event);

                                // Reload the page to reflect changes
                                window.location.reload();
                            } else {
                                throw new Error(data.message || 'Failed to remove image');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const event = new CustomEvent('show-toast', {
                                detail: {
                                    message: error.message || 'An error occurred while removing the image',
                                    type: 'error'
                                }
                            });
                            document.dispatchEvent(event);
                        });
                }
            }

            // Preview uploaded images before submitting
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const files = e.target.files;
                const thumbnailsContainer = document.getElementById('image-thumbnails');

                // Clear existing "no images" message if present
                if (thumbnailsContainer.querySelector('p')) {
                    thumbnailsContainer.innerHTML = '';
                }

                // Process each file
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        continue;
                    }

                    // Create a thumbnail preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const thumbnail = document.createElement('div');
                        thumbnail.className = 'relative group';
                        thumbnail.innerHTML = `
                        <img src="${e.target.result}"
                             alt="Preview"
                             class="w-full h-32 object-cover rounded-lg border border-airbnb-darkest">
                        <button type="button" onclick="this.parentNode.remove()"
                                class="absolute top-1 right-1 bg-white rounded-full p-1 opacity-0 group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    `;
                        thumbnailsContainer.appendChild(thumbnail);
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
