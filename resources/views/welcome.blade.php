<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siakad MIS</title>
    <meta name="description"
        content="Get started with a free landing page built with Tailwind CSS and the Flowbite Blocks system.">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <header>
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <div class="flex items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/id/4/44/Logo_PENS.png" class="mr-3 h-6 sm:h-9"
                        alt="Pens Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-blue-400">Siakad MIS</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center lg:order-2">
                        {{--
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                         @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth --}}


                        @auth
                            <a href="{{ url('/MIS') }}"
                                class="font-semibold text-blue-400 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-400 text-white hover:bg-blue-600 focus:ring-0 font-medium rounded-lg text-lg px-5 py-2.5 mr-2 border border-blue-400 shadow-md">
                                Log in
                            </a>
                        @endauth
                @endif
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-blue-400 hover:text-blue-600 lg:p-0">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pr-4 pl-3 text-blue-400 hover:text-blue-600 lg:p-0">About</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pr-4 pl-3 text-blue-400 hover:text-blue-600 lg:p-0">Services</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-blue-400 hover:text-blue-600 lg:p-0">FAQ</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pr-4 pl-3 text-blue-400 hover:text-blue-600 lg:p-0">Contact</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
    </header>
    {{-- bagian isi landing page --}}
    
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>
