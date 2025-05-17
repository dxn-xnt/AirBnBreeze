@extends('layouts.app')

@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <!-- Photo Upload Section -->
        <form id="picturesForm" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-[8%]">
                <div class="flex justify-between mb-3">
                    <h2 class="text-left text-3xl font-extrabold text-gray-900">
                        Listing Editor
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ url()->previous() }}" class="min-w-[150px] inline-flex justify-center py-2 px-4 border-[1px] border-airbnb-dark shadow-sm text-lg font-medium rounded-full text-airbnb-dark bg-airbnb-light hover:text-airbnb-darkest hover:border-airbnb-darkest focus:outline-none focus:ring-airbnb-light">
                            Back
                        </a>
                        <button type="submit" class="min-w-[150px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-full text-airbnb-light bg-airbnb-dark hover:bg-airbnb-darkest hover:text-airbnb-light hover:border-airbnb-dark focus:outline-none focus:ring-airbnb-dark">
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
                    <a href="{{ route('property.edit.pictures', ['property' => $property->prop_id]) }}"  class="p-2 border-[1px] border-airbnb-dark bg-airbnb-dark rounded-lg text-airbnb-light">Pictures</a>
                    <a href="{{ route('property.edit.price', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">Price</a>
                    <a href="{{ route('property.edit.rules', ['property' => $property->prop_id]) }}" class="p-2 border-[1px] border-airbnb-dark rounded-lg text-airbnb-darkest">House Rules</a>
                </div>
            </div>

            <div class="m-auto w-full max-w-screen-md px-8 py-8">
                <h3 class="text-xl font-medium text-gray-900 mb-2">Add some photos of your house</h3>
                <!-- File Input -->
                <div class="border-2 border-dashed border-airbnb-darkest rounded-xl px-6 py-6 text-center mb-4 min-h-72">
                    <!-- Display Uploaded Images -->
                    <div id="image-thumbnails" class="grid grid-cols-3 gap-4 mb-4">
                        @if($propertyImages && count($propertyImages) > 0)
                            @foreach($propertyImages as $index => $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->img_url) }}" alt="Property image" class="w-full h-32 object-cover rounded-sm border border-airbnb-darkest">
                                    <button type="button" onclick="removeImage({{ $index }})" class="absolute top-1 right-1 bg-white rounded-full p-1 opacity-0 group-hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @elseif(session('property_images') && count(session('property_images')) > 0)
                            @foreach(session('property_images') as $index => $img_url)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $imageUrl) }}" alt="Thumbnail" class="w-full h-32 object-cover rounded-sm border border-airbnb-darkest">
                                    <button type="button" onclick="removeImage({{ $index }})" class="absolute top-1 right-1 bg-white rounded-full p-1 opacity-0 group-hover:opacity-100">
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
        </form>
    </div>

    <script>
        // Array to store uploaded images
        let uploadedImages = @json($propertyImages->pluck('img_url') ?? []);

        // Function to display uploaded images
        function displayImageThumbnails() {
            const thumbnailsContainer = document.getElementById('image-thumbnails');
            thumbnailsContainer.innerHTML = ''; // Clear existing thumbnails

            console.log('Current images:', uploadedImages);

            if (uploadedImages.length === 0) {
                thumbnailsContainer.innerHTML = '<p class="col-span-3 text-center text-gray-500">No images uploaded yet</p>';
                return;
            }

            uploadedImages.forEach((image, index) => {
                const isBlobUrl = image.startsWith('blob:');
                const imageUrl = isBlobUrl ? image : `/storage/${image}`;

                console.log(`Displaying image ${index}:`, imageUrl);

                const thumbnail = document.createElement('div');
                thumbnail.className = 'relative group';
                thumbnail.innerHTML = `
                <img src="${imageUrl}"
                     alt="Property image"
                     class="w-full h-32 object-cover rounded-lg border border-airbnb-darkest">
                <button type="button" onclick="removeImage(${index}, ${isBlobUrl})"
                        class="absolute top-1 right-1 bg-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
                thumbnailsContainer.appendChild(thumbnail);
            });
        }

        // Function to remove an image
        function removeImage(index, isBlobUrl = false) {
            if (confirm('Are you sure you want to remove this image?')) {
                if (isBlobUrl) {
                    // Client-side only removal
                    uploadedImages.splice(index, 1);
                    displayImageThumbnails();
                } else {
                    // Server-side removal
                    const imagePath = uploadedImages[index];
                    fetch('/property/remove-image', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ imagePath })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                uploadedImages.splice(index, 1);
                                displayImageThumbnails();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to remove image');
                        });
                }
            }
        }

        // Handle file upload
        document.getElementById('file-upload').addEventListener('change', function (e) {
            const files = e.target.files;

            // Process each file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // Validate file type
                if (!file.type.match('image.*')) {
                    continue;
                }

                // Create a URL for the thumbnail
                const imageUrl = URL.createObjectURL(file);

                // Add to uploaded images array
                uploadedImages.push(imageUrl);

                // Display thumbnails
                displayImageThumbnails();
            }
        });

        // Initial display
        displayImageThumbnails();
    </script>
@endsection
