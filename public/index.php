<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduX - Plateforme d'Apprentissage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'yellow-custom': '#FFD700',
                    'yellow-bright': '#FFEB3B'
                },
                animation: {
                    'float': 'float 3s ease-in-out infinite',
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                }
            }
        }
    }
    </script>
    <style>
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .geometric-shape {
        transition: all 0.3s ease;
    }

    .geometric-shape:hover {
        transform: rotate(180deg) scale(1.1);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <nav class="bg-white shadow-sm px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <div class="text-2xl font-bold">EduX</div>
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-black transition">Categories</a>
                    <a href="#" class="text-gray-600 hover:text-black transition">Instructors</a>
                    <a href="#" class="text-gray-600 hover:text-black transition">Contact Us</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-black transition">Sign In</button>
                <button class="bg-black text-white px-6 py-2 rounded-full hover:bg-gray-800 transition">Sign Up</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-white py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="relative">
                <div class="absolute -top-10 -left-10 w-4 h-4 bg-yellow-400 rounded-full animate-float"></div>
                <div class="absolute top-20 -right-10 w-3 h-3 bg-black rounded-full animate-pulse-slow"></div>
                <div class="absolute -bottom-5 left-20 geometric-shape">
                    <div class="w-8 h-8 border-2 border-gray-300 rotate-45"></div>
                </div>

                <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    There's a New<br>
                    Way to Learn<br>
                    <span class="text-gray-400">More...</span>
                </h1>

                <p class="text-gray-600 text-lg mb-8 max-w-md">
                    By connecting students all over the world to the best instructors. We're building a global school
                    without borders.
                </p>

                <button
                    class="bg-black text-white px-8 py-4 rounded-full hover:bg-gray-800 transition-all duration-300 hover:scale-105">
                    <a href="login.php">
                        Get Started
                    </a>
                </button>
            </div>

            <!-- Right Illustration -->
            <div class="relative flex justify-center items-center">
                <div class="relative">
                    <!-- Main circular background -->
                    <div class="w-80 h-80 bg-yellow-400 rounded-full flex items-center justify-center relative">
                        <!-- Character illustration -->
                        <div class="relative">
                            <div class="w-32 h-32 bg-white rounded-full mb-4 relative overflow-hidden">
                                <!-- Simple face -->
                                <div class="absolute top-8 left-8 w-4 h-4 bg-black rounded-full"></div>
                                <div class="absolute top-8 right-8 w-4 h-4 bg-black rounded-full"></div>
                                <div
                                    class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-8 h-2 bg-black rounded-full">
                                </div>
                            </div>
                            <!-- Laptop -->
                            <div class="w-24 h-16 bg-gray-800 rounded-lg mx-auto relative">
                                <div class="w-20 h-12 bg-white rounded-sm absolute top-2 left-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating elements -->
                    <div class="absolute -top-10 -right-10 w-20 h-20 bg-black rounded-full animate-float"></div>
                    <div class="absolute -bottom-10 -left-10 geometric-shape">
                        <div class="w-16 h-16 border-4 border-yellow-400 transform rotate-45"></div>
                    </div>
                    <div class="absolute top-10 -left-20 w-6 h-6 bg-yellow-400 rounded-full animate-pulse-slow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="card-hover bg-white p-8 rounded-2xl shadow-lg relative overflow-hidden">
                    <div
                        class="absolute top-4 right-4 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center">
                        <div class="w-6 h-6 bg-black rounded-sm"></div>
                    </div>

                    <div class="mb-6">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full"></div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mb-4">Start Your Free Trial Classes</h3>
                    <p class="text-gray-600 mb-6">
                        Start with our talented advisors and build your skills. Build your favorite and take control of
                        your career.
                    </p>
                    <button class="bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition">
                        Start Now
                    </button>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover bg-white p-8 rounded-2xl shadow-lg relative">
                    <div class="mb-6 relative">
                        <div
                            class="w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center mb-4 relative">
                            <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                                <div class="w-6 h-6 bg-white rounded-sm"></div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mb-4">We Know How to Build Your Knowledge</h3>
                    <p class="text-gray-600 mb-6">
                        Discover your online learning from top universities and organizations. Understand the world's
                        people with us and learn new skills.
                    </p>
                    <button
                        class="bg-yellow-400 text-black px-6 py-3 rounded-full hover:bg-yellow-500 transition font-semibold">
                        Get Started
                    </button>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover bg-white p-8 rounded-2xl shadow-lg relative">
                    <div class="mb-6 relative">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <div class="w-10 h-10 bg-yellow-400 rounded-lg transform rotate-12"></div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mb-4">Download Our Mobile App</h3>
                    <p class="text-gray-600 mb-6">
                        Having an application that makes learning easy and accessible. Download our mobile app to
                        enhance your learning journey.
                    </p>
                    <button class="bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition">
                        Download
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Our Popular Course</h2>
            <p class="text-gray-600 mb-12">By connecting students all over the world to the best instructors, for our
                future</p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover bg-gray-50 p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <div class="w-8 h-8 bg-black rounded-sm"></div>
                    </div>
                    <h3 class="font-semibold mb-2">Software Development</h3>
                    <p class="text-gray-600 text-sm">Learn modern programming languages and frameworks</p>
                </div>

                <div class="card-hover bg-gray-50 p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <div class="w-8 h-8 bg-black rounded-full"></div>
                    </div>
                    <h3 class="font-semibold mb-2">Digital Marketing</h3>
                    <p class="text-gray-600 text-sm">Master the art of online marketing and growth</p>
                </div>

                <div class="card-hover bg-gray-50 p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <div class="w-8 h-8 bg-black transform rotate-45"></div>
                    </div>
                    <h3 class="font-semibold mb-2">Graphic Design</h3>
                    <p class="text-gray-600 text-sm">Create stunning visuals and user experiences</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 bg-yellow-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <div class="w-10 h-10 bg-black rounded-full"></div>
                </div>
                <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
                <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
                    Join thousands of students who are already transforming their careers with our expert-led courses.
                </p>
                <button
                    class="bg-yellow-400 text-black px-8 py-4 rounded-full hover:bg-yellow-500 transition-all duration-300 hover:scale-105 font-semibold">
                    Start Your Journey
                </button>
            </div>

            <div class="border-t border-gray-800 pt-8 mt-12">
                <p class="text-gray-400">© 2025 EduX. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    // Add subtle parallax effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.geometric-shape');

        parallaxElements.forEach(element => {
            const speed = 0.5;
            element.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
        });
    });

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.card-hover').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    </script>
</body>

</html>