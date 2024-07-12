<!-- resources/views/user-management.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">User Management</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    <table class="table-auto w-full bg-white shadow-md rounded">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>ID Jabatan</th>
                <th>NIP</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id_user }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->id_jabatan }}</td>
                    <td>{{ $user->nip }}</td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="editUser({{ $user->id_user }})">Edit</button>
                        <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<x-modal id="editModal" class="hidden">
    <x-slot name="title">
        Edit User
    </x-slot>
    <x-slot name="body">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded" required>
            </div>
            <!-- Add other fields here -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal()">Cancel</button>
        </form>
    </x-slot>
</x-modal>


<script>
    function editUser(id_user) {
        fetch(`/admin/users/${id_user}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/users/${id_user}`;
                document.getElementById('name').value = data.name;
                document.getElementById('email').value = data.email;
                // Populate other fields
                document.getElementById('editModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
