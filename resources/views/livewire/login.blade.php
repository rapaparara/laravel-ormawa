<div>
    <div>
        <div class="bg-gray-50 mx-3 px-4 py-5 rounded-lg shadow-sm">
            <h1 class="px-2 ps-4 text-indigo-900 text-4xl font-bold drop-shadow-sm"><i
                    class="fa-solid fa-right-to-bracket"></i> Halaman Masuk
            </h1>
        </div>
        <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Silakan masuk disini
            </h5>
            <div class="mt-3 max-w-md text-gray-700 dark:text-gray-400 font-normal">
                <x-flash-message />
                <form wire:submit="login" class="mx-auto">
                    <div class="mb-5">
                        <label for="text" class="block mb-2 text-md font-medium">Username</label>
                        <input wire:model="form.username" type="text" id="username"
                            class="bg-white border-gray-400 text-sm rounded-lg focus:ring-indigo-700 focus:border-indigo-700 block w-full p-2.5 "
                            placeholder="Masukkan username anda disini.." />
                        @error('form.username')
                            <small class="text-red-600 font-medium">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-md font-medium">Password </label>
                        <input wire:model="form.password" type="password" id="password"
                            class="bg-white border border-gray-400 text-sm rounded-lg focus:ring-indigo-700 focus:border-indigo-700 block w-full p-2.5"
                            placeholder="Masukkan password anda disini.." />
                        @error('form.password')
                            <small class="text-red-600 font-medium">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit"
                        class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Masuk</button>
                </form>

            </div>
        </div>
    </div>
</div>
