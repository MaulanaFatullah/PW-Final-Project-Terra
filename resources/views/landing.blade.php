<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo/favicon.ico') }}" type="image/x-icon">

    <title>Terra | Italian Restaurant</title>
    @vite('resources/css/app.css')
    <style>
        @media (max-width: 767px) {
            .mobile-bg-image {
                position: relative;
                background-image: url('{{ asset('images/hero-right.png') }}');
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
            }
            .mobile-bg-image::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.3);
                pointer-events: none;
                z-index: 0;
            }
            .mobile-bg-image > * {
                position: relative;
                z-index: 1;
            }
        }

        @media (min-width: 768px) {
            .mobile-bg-image {
                background-image: none !important;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 ">
    <!-- Navigation Bar -->
    <header class="fixed top-0 left-0 w-full z-50">
        <div class="backdrop-blur-md bg-choco-900 flex justify-between items-center px-10 py-4 bg-opacity-20">
            <img src="{{ asset('images/logo/logo-terra.png') }}" alt="Terra Logo" class="h-10">
            <nav class="space-x-6 text-white font-serif text-lg">
                <a href="#home" class="hover:text-yellow-200 transition">Home</a>
                <a href="#menu" class="hover:text-yellow-200 transition">Menu</a>
                <a href="#gallery" class="hover:text-yellow-200 transition">Gallery</a>
                <a href="#space" class="hover:text-yellow-200 transition">Space</a>
                <!-- <a href="#faq" class="hover:text-yellow-200 transition">FAQ</a> -->
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex">
        {{-- Left Side (Text) --}}
        <div class="md:w-1/2 w-full mobile-bg-image bg-cover bg-center bg-no-repeat md:bg-none md:bg-choco-800 text-white flex flex-col justify-between px-12 py-10">
            <div class="my-auto">
                <h1 class="text-4xl md:text-5xl font-serif font-bold leading-tight">
                    Terra is a Michelin-starred restaurant<br>
                    that offers a sophisticated exploration<br>
                    of Italian’s culinary heritage.
                </h1>
                <a href="#reservation" class="inline-block mt-8 px-6 py-3 border border-white rounded text-white hover:bg-white hover:text-[#5B2C1F] transition">
                    Reservation →
                </a>
            </div>
        </div>

        {{-- Right Side (Image) --}}
        <div class="w-0 md:w-1/2">
            <img src="{{ asset('images/hero-right.png') }}" alt="Interior" class="w-full h-full shadow-lg object-cover">
        </div>
    </section>



    <!-- Menu Section -->
    <section id="menu" class="bg-choco-700 py-16 ">
        <div class="mx-auto">
            <!-- Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left Column -->
                <div class="flex flex-col gap-6">
                    <img src="{{ asset('images/menu/Bruschetta.png') }}" alt="Menu Left 1" class="shadow-lg object-none w-full">
                    <img src="{{ asset('images/menu/Tomato-topped-bread.png') }}" alt="Menu Left 2" class="shadow-lg object-none w-full">
                    <img src="{{ asset('images/menu/Ravioli.png') }}" alt="Menu Left 3" class="shadow-lg object-none w-full">
                </div>

                <!-- Right Column -->
                <div class="flex flex-col gap-6">
                    <!-- Menu Title -->
                    <div class="flex items-center justify-center h-[150px] text-white text-4xl font-serif">
                        ~ Menu ~
                    </div>

                    <!-- Right Images -->
                    <img src="{{ asset('images/menu/Pasta-soup.png') }}" alt="Menu Right 1" class="shadow-lg object-none w-full">
                    <img src="{{ asset('images/menu/Penne-pasta.png') }}" alt="Menu Right 2" class="shadow-lg object-none w-full">
                    <img src="{{ asset('images/menu/Tiramisu.png') }}" alt="Menu Right 3" class="shadow-lg object-none w-full">
                </div>

            </div>
        </div>
    </section>



    <!-- Gallery Section -->
    <section id="gallery" class="bg-choco-800 py-16">
        <div class="mx-auto">
            <!-- Title -->
            <h2 class="text-white text-center text-2xl font-serif mb-10">- Gallery -</h2>

            <!-- Grid Layout -->
            <div class="grid grid-cols-4 md:grid-cols-8 gap-4">

                <!-- Top Row -->
                <img src="{{ asset('images/gallery/image-1.png') }}" alt="Gallery 1" class="col-span-2 md:col-span-2 object-cover w-full h-96 shadow-lg">
                <img src="{{ asset('images/gallery/image-2.png') }}" alt="Gallery 2" class="col-span-2 md:col-span-2 object-cover w-full h-96 shadow-lg">
                <img src="{{ asset('images/gallery/image-3.png') }}" alt="Gallery 3" class="col-span-2 md:col-span-4 object-cover w-full h-96 shadow-lg">

                <!-- Bottom Row -->
                <img src="{{ asset('images/gallery/image-4.png') }}" alt="Gallery 4" class="col-span-2 md:col-span-4 object-cover w-full h-96 shadow-lg">
                <img src="{{ asset('images/gallery/image-5.png') }}" alt="Gallery 5" class="col-span-2 md:col-span-2 object-cover w-full h-96 shadow-lg">
                <img src="{{ asset('images/gallery/image-6.png') }}" alt="Gallery 6" class="col-span-2 md:col-span-2 object-cover w-full h-96 shadow-lg">

            </div>
        </div>
    </section>


    <!-- Space Info Section with Accordion -->
    <section id="space" class="bg-choco-700 text-white font-serif px-6 md:px-0 md:pl-6 py-16">
        <div class="mx-auto flex flex-col md:flex-row gap-12">

            <!-- Accordion Left -->
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-normal mb-8 tracking-widest text-center">_ Space _</h2>

                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="border-b border-white pb-4">
                        <button onclick="toggleAccordion(0)" class="w-full flex justify-between items-center text-2xl focus:outline-none">
                            <span>The Salon</span>
                            <span>+</span>
                        </button>
                        <div class="mt-2 hidden text-white text-lg" id="accordion-0">
                            Elegant seating for intimate conversations or casual dining.
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="border-b border-white pb-4">
                        <button onclick="toggleAccordion(1)" class="w-full flex justify-between items-center text-2xl focus:outline-none">
                            <span>The Dining Room</span>
                            <span>+</span>
                        </button>
                        <div class="mt-2 hidden text-white text-lg" id="accordion-1">
                            Spacious and warm setting ideal for family meals or events.
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="border-b border-white pb-4">
                        <button onclick="toggleAccordion(2)" class="w-full flex justify-between items-center text-2xl focus:outline-none">
                            <span>The Counter</span>
                            <span>+</span>
                        </button>
                        <div class="mt-2 hidden text-white text-lg" id="accordion-2">
                            Chef’s counter experience for food lovers who enjoy watching the kitchen in action.
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="border-b border-white pb-4">
                        <button onclick="toggleAccordion(3)" class="w-full flex justify-between items-center text-2xl focus:outline-none">
                            <span>Large Parties & Events</span>
                            <span>+</span>
                        </button>
                        <div class="mt-2 hidden text-white text-lg" id="accordion-3">
                            Private space available for celebrations, corporate gatherings, and more.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Right -->
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/dining-room.png') }}" alt="Dining Space" class="w-full h-auto object-cover rounded-md shadow-lg">
            </div>
        </div>
    </section>

    <script>
        function toggleAccordion(index) {
            const panel = document.getElementById(`accordion-${index}`);
            panel.classList.toggle('hidden');
        }
    </script>


    <!-- Footer -->
    <footer class="bg-choco-800 font-serif text-white text-center py-6">
        <p>&copy; {{ date('Y') }} Terra Restaurant. All rights reserved.</p>
    </footer>

</body>

</html>