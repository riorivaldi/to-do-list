<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    @vite('resources/css/app.css')
    <title>To-Do-List</title>
</head>
<body class="flex flex-col justify-center items-center p-12 bg-[#E7E8EA] relative overflow-hidden">

    <img src="{{ asset('img/goat.jpg') }}" alt="logo" width="100" height="100" class="w-[90px] h-[90px] rounded-full">
    <h1 class="font-bold text-[20px] mt-2">To Do List</h1>


    {{-- Form tambah todo --}}
    <form action="/store" method="POST" class="flex flex-col gap-3 w-full max-w-md mb-4 mt-3">
        @csrf
        <input type="text" name="title" class="h-12 w-full py-2 px-4 border border-gray-200 rounded-full focus:outline-none focus:ring-1 focus:ring-black bg-white shadow-md" placeholder="
agrega tu nombre" required>

        <input type="datetime-local" name="datetime" class="h-12 w-full py-2 px-4 border border-gray-200 rounded-full focus:outline-none focus:ring-1 focus:ring-black bg-white shadow-md" required>

        <button type="submit" class="h-12 px-5 rounded-full shadow-md focus:ring-1 focus:ring-black font-semibold bg-gray-500 text-white hover:bg-gray-900 transition">
agrega tu nombre</button>
    </form>

    <div class="bg-gradient-to-r bg-[#C1C9DD] flex justify-center items-center min-w-[500px] rounded-xl shadow-lg overflow-y-auto pt-4 max-h-[300px]">
        {{-- Daftar Todo --}}
        <ul class="w-full max-w-md">
            @foreach($todos as $todo)
                <li class="flex justify-between items-center p-4 mb-4 pt-1 rounded-xl shadow-md bg-white">
                    <div class="flex items-center gap-x-3 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <form action="/toggle-complete/{{ $todo->id }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="relative cursor-pointer">
                                <input type="checkbox" onchange="this.form.submit()" {{ $todo->completed ? 'checked' : '' }}
                                    class="peer hidden">
                                <div class="w-6 h-6 flex items-center justify-center border-2 border-gray-400 rounded-md bg-white peer-checked:bg-blue-700 peer-checked:border-blue-700 transition-all duration-300">
                                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                        </form>

                        <div class="text-lg font-medium transition-all duration-300">
                            <div class="flex justify-between items-center">
                                <span class="{{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }} w-full flex justify-between items-center">
                                    <span>{{ $todo->title }}</span>
                                    <span class="text-sm text-gray-500 ml-4">
                                        {{ \Carbon\Carbon::parse($todo->datetime)->format('d M Y, H:i') }}
                                    </span>
                                </span>
                            </div>
                        </div>


                    </div>

                    <div class="flex items-center gap-x-2">
                        {{-- Tombol Edit (Buka Modal) --}}
                        <button onclick="openEditModal('{{ $todo->id }}', '{{ $todo->title }}', '{{ $todo->datetime }}')">
                            <i class="ri-edit-line text-blue-500 hover:text-blue-700 cursor-pointer"></i>
                        </button>

                        {{-- Tombol Hapus --}}
                        <form id="deleteForm-{{ $todo->id }}" action="/delete/{{ $todo->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $todo->id }})">
                                <i class="ri-delete-bin-line text-red-500 hover:text-red-700"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>




    {{-- MODAL EDIT TODO --}}
    <div id="modalOverlay" class="hidden fixed inset-0 backdrop-blur-md bg-black/10 z-40"></div>

    <div id="editModal" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg max-w-md w-full z-50 border border-gray-300">
        <h2 class="text-2xl font-bold mb-4">Edit Task</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PATCH')

            {{-- Hidden ID, opsional jika diperlukan --}}
            <input type="hidden" id="editId" name="id">

            {{-- Title --}}
            <input type="text" id="editTitle" name="title"
                class="h-12 w-full py-2 px-4 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-black bg-white shadow-md"
                required>

            {{-- Datetime --}}
            <input type="datetime-local" id="editDatetime" name="datetime"
                class="h-12 w-full py-2 px-4 mt-4 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-black bg-white shadow-md"
                required>

            {{-- Tombol Submit --}}
            <button type="submit"
                class="w-full mt-4 h-12 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition">
                UPDATE
            </button>
        </form>

        {{-- Tombol Close --}}
        <button onclick="closeEditModal()"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <i class="ri-close-line text-2xl"></i>
        </button>
    </div>


    <script>
        function openEditModal(id, title, datetime) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
            document.getElementById('editTitle').value = title;
            document.getElementById('editForm').action = "/edit/" + id;
            document.getElementById('edit-datetime').value = datetime;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('modalOverlay').classList.add('hidden');
        }
    </script>

<script>
    function confirmDelete(todoId) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + todoId).submit();
            }
        });
    }
</script>


</body>
</html>
