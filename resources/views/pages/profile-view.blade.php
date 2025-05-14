@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <!-- Profile Info -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex items-center space-x-4">
            <img class="w-24 h-24 rounded-full object-cover" src="{{ asset('storage/profile.jpg') }}" alt="Profile Picture">
            <div>
                <h2 class="text-2xl font-semibold">{{ $owner->name }}</h2>
                <p class="text-gray-500">{{ $owner->address }}</p>
                <p class="text-gray-500">{{ $owner->email }}</p>
                <p class="text-gray-500">Phone: {{ $owner->phone }}</p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('owner.edit', $owner->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Edit Profile</a>
            </div>
        </div>
        <div class="mt-4 text-gray-700">
            <p>{{ $owner->bio }}</p>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Notifications</h3>
        <ul class="list-disc pl-5 text-gray-700">
            @forelse ($notifications as $note)
                <li>{{ $note->message }} <span class="text-sm text-gray-400">({{ $note->created_at->diffForHumans() }})</span></li>
            @empty
                <li>No notifications available.</li>
            @endforelse
        </ul>
    </div>

    <!-- Properties -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4">{{ $owner->name }}'s Properties</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($properties as $property)
                <div class="border rounded-lg overflow-hidden shadow hover:shadow-md transition">
                    <img src="{{ asset('storage/properties/' . $property->image) }}" alt="{{ $property->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">{{ $property->name }}</h4>
                        <p class="text-gray-500">{{ $property->location }}</p>
                        <p class="text-green-600 font-bold">₱ {{ number_format($property->price, 2) }} / night</p>
                        <div class="text-yellow-400">★ {{ number_format($property->rating, 1) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($hasMoreProperties)
            <div class="text-center mt-6">
                <a href="{{ route('owner.properties', ['owner' => $owner->id]) }}" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Show More</a>
            </div>
        @endif
    </div>
</div>
@endsection

<!-- Additional Files Below -->

// routes/web.php
Route::get('/owner/{id}/edit', [OwnerController::class, 'edit'])->name('owner.edit');
Route::put('/owner/{id}', [OwnerController::class, 'update'])->name('owner.update');

// app/Http/Controllers/OwnerController.php
public function edit($id)
{
    $owner = Owner::findOrFail($id);
    return view('owner.edit', compact('owner'));
}

public function update(Request $request, $id)
{
    $owner = Owner::findOrFail($id);
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'bio' => 'nullable|string',
    ]);

    $owner->update($request->all());

    return redirect()->route('owner.edit', $owner->id)->with('success', 'Profile updated successfully.');
}

// resources/views/owner/edit.blade.php
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('owner.update', $owner->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" value="{{ $owner->name }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Address</label>
            <input type="text" name="address" value="{{ $owner->address }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ $owner->email }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Phone</label>
            <input type="text" name="phone" value="{{ $owner->phone }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Bio</label>
            <textarea name="bio" class="w-full border px-4 py-2 rounded">{{ $owner->bio }}</textarea>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Save Changes</button>
    </form>
</div>
@endsection
