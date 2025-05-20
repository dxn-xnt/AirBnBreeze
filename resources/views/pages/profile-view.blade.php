@extends('layouts.app')
@section('content')
    <div class="relative w-full h-full mt-28 mb-10 bg-airbnb-lightest gap-2">
        <!-- Profile Info -->
        <div class="m-auto max-w-screen-lg">
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-2">
                About {{ $user->user_fname }} {{ $user->user_lname }}
            </h1>
            <div class="flex gap-10 w-full py-6 px-8 border border-airbnb-darkest rounded-xl">
                <div class="flex flex-col items-center gap-4">
                    <!-- Profile Picture -->
                    <img id="profile-picture"
                         class="w-52 h-52 rounded-full object-cover border border-airbnb-darkest"
                         src="{{ $user->user_profile ? asset('storage/' . $user->user_profile) : asset('images/default-profile.jpg') }}"
                         alt="Profile Picture">
                    <!-- Hidden file input for profile picture -->
                    <input type="file" id="profile-picture-input" class="hidden" accept="image/*">
                    <div class="flex gap-2">
                        <button id="edit-profile-btn"
                                class="text-airbnb-darkest text-sm border border-airbnb-darkest hover:shadow-md px-8 rounded-full">
                            Edit Profile
                        </button>
                        <div id="save-cancel-btns" class="hidden flex gap-2">
                            <button id="save-btn" class="text-white text-sm bg-airbnb-darkest hover:shadow-md px-8 rounded-full">
                                Save
                            </button>
                            <button id="cancel-btn" class="text-airbnb-darkest text-sm border border-airbnb-darkest hover:shadow-md px-8 rounded-full">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <div class="w-full space-y-6">
                    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-6">
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Name</p>
                                <div class="view-mode">
                                    <p class="view-name text-airbnb-darkest text-lg font-semibold">{{ $user->user_fname }} {{ $user->user_lname }}</p>
                                </div>
                                <div class="edit-mode hidden">
                                    <input type="text" name="user_fname" value="{{ $user->user_fname }}" class="text-airbnb-darkest text-lg font-semibold border border-airbnb-dark rounded px-2 py-1 w-full">
                                    <input type="text" name="user_lname" value="{{ $user->user_lname }}" class="text-airbnb-darkest text-lg font-semibold border border-airbnb-dark rounded px-2 py-1 w-full mt-2">
                                </div>
                            </div>
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Email</p>
                                <div class="view-mode">
                                    <p class="view-email text-airbnb-darkest text-lg font-semibold">{{ $user->user_email }}</p>
                                </div>
                                <div class="edit-mode hidden">
                                    <input type="email" name="user_email" value="{{ $user->user_email }}" class="text-airbnb-darkest text-lg font-semibold border border-airbnb-dark rounded px-2 py-1 w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-6">
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Phone Number</p>
                                <div class="view-mode">
                                    <p class="view-phone text-airbnb-darkest text-lg font-semibold">{{ $user->user_contact_number }}</p>
                                </div>
                                <div class="edit-mode hidden">
                                    <input type="text"
                                           name="user_contact_number"
                                           value="{{ $user->user_contact_number }}"
                                           maxlength="11"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                           class="text-airbnb-darkest text-lg font-semibold border border-airbnb-dark rounded px-2 py-1 w-full">
                                </div>
                            </div>
                            <div class="w-full">
                                <p class="text-airbnb-dark text-sm italic">Joined Since</p>
                                <p class="text-airbnb-darkest text-lg font-semibold">
                                    {{ \Carbon\Carbon::parse($user->user_date_created)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-airbnb-dark text-sm italic">About</p>
                        <div class="view-mode">
                            <p class="view-about text-airbnb-darkest text-md font-regular">
                                {{ $user->user_about ?? 'No about information provided' }}
                            </p>
                        </div>
                        <div class="edit-mode hidden">
                            <textarea name="user_about" class="text-airbnb-darkest text-md font-regular border border-airbnb-dark rounded px-2 py-1 w-full h-32">{{ $user->user_about }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Properties -->
        <div class="m-auto max-w-screen-lg mt-8">
            <h1 class="text-[1.5rem] sm:text-[1.75rem] font-semibold text-airbnb-darkest mb-2">
                {{ $user->user_fname }} {{ $user->user_lname }}'s Properties
            </h1>
            <div class="w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 sm:gap-x-8 lg:gap-x-9 gap-y-8 sm:gap-y-10 lg:gap-y-12 mb-8 mx-auto">
                    @foreach($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const saveBtn = document.getElementById('save-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const saveCancelBtns = document.getElementById('save-cancel-btns');
            const viewModeElements = document.querySelectorAll('.view-mode');
            const editModeElements = document.querySelectorAll('.edit-mode');
            const profilePicture = document.getElementById('profile-picture');
            const profilePictureInput = document.getElementById('profile-picture-input');

            // Store original values for revert on cancel
            const originalValues = {
                fname: document.querySelector('input[name="user_fname"]').value,
                lname: document.querySelector('input[name="user_lname"]').value,
                email: document.querySelector('input[name="user_email"]').value,
                contact: document.querySelector('input[name="user_contact_number"]').value,
                about: document.querySelector('textarea[name="user_about"]').value,
                profilePic: profilePicture.src
            };

            // Toggle Edit Mode
            editProfileBtn.addEventListener('click', function () {
                viewModeElements.forEach(el => el.classList.add('hidden'));
                editModeElements.forEach(el => el.classList.remove('hidden'));
                editProfileBtn.classList.add('hidden');
                saveCancelBtns.classList.remove('hidden');
                profilePicture.style.cursor = 'pointer';
                profilePicture.title = 'Click to change profile picture';
            });

            // Cancel Button - Revert to View Mode
            cancelBtn.addEventListener('click', function () {
                exitEditMode();
                revertToOriginalValues();
            });

            // Click on Profile Picture to Change Image
            profilePicture.addEventListener('click', function () {
                if (!saveCancelBtns.classList.contains('hidden')) {
                    profilePictureInput.click();
                }
            });

            // Preview Selected Profile Picture
            profilePictureInput.addEventListener('change', function (e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        profilePicture.src = event.target.result;
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // Save Button - Submit via AJAX
            saveBtn.addEventListener('click', function () {
                saveBtn.disabled = true;
                saveBtn.innerHTML = 'Saving...';

                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('user_fname', document.querySelector('input[name="user_fname"]').value);
                formData.append('user_lname', document.querySelector('input[name="user_lname"]').value);
                formData.append('user_email', document.querySelector('input[name="user_email"]').value);
                formData.append('user_contact_number', document.querySelector('input[name="user_contact_number"]').value);
                formData.append('user_about', document.querySelector('textarea[name="user_about"]').value);

                if (profilePictureInput.files[0]) {
                    formData.append('user_profile', profilePictureInput.files[0]);
                }

                fetch("{{ route('owner.update', $user->user_id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw { status: response.status, data };
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            updateViewModeFields(data);
                            originalValues.fname = data.user_fname;
                            originalValues.lname = data.user_lname;
                            originalValues.email = data.user_email;
                            originalValues.contact = data.user_contact_number;
                            originalValues.about = data.user_about;
                            if (data.user_profile) originalValues.profilePic = data.user_profile;

                            exitEditMode();
                            alert('Profile updated successfully!');
                        } else {
                            alert('Error: ' + (data.message || 'Failed to update profile'));
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        if (error.data && error.data.errors && error.data.errors.user_contact_number) {
                            alert(error.data.errors.user_contact_number[0]);
                        } else if (error.data && error.data.message) {
                            alert(error.data.message);
                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    })
                    .finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = 'Save';
                    });
            });

            // Helper functions
            function exitEditMode() {
                viewModeElements.forEach(el => el.classList.remove('hidden'));
                editModeElements.forEach(el => el.classList.add('hidden'));
                editProfileBtn.classList.remove('hidden');
                saveCancelBtns.classList.add('hidden');
                profilePicture.style.cursor = '';
                profilePicture.title = '';
            }

            function revertToOriginalValues() {
                document.querySelector('input[name="user_fname"]').value = originalValues.fname;
                document.querySelector('input[name="user_lname"]').value = originalValues.lname;
                document.querySelector('input[name="user_email"]').value = originalValues.email;
                document.querySelector('input[name="user_contact_number"]').value = originalValues.contact;
                document.querySelector('textarea[name="user_about"]').value = originalValues.about;
                profilePicture.src = originalValues.profilePic;
                profilePictureInput.value = '';
            }

            function updateViewModeFields(data) {
                const nameEl = document.querySelector('.view-name');
                const emailEl = document.querySelector('.view-email');
                const phoneEl = document.querySelector('.view-phone');
                const aboutEl = document.querySelector('.view-about');

                if (nameEl) nameEl.textContent = `${data.user_fname} ${data.user_lname}`;
                if (emailEl) emailEl.textContent = data.user_email;
                if (phoneEl) phoneEl.textContent = data.user_contact_number;
                if (aboutEl) aboutEl.textContent = data.user_about || 'No about information provided';
                if (data.user_profile) profilePicture.src = data.user_profile;
            }
        });
    </script>
@endsection
