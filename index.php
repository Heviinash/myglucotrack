<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - MyGlucoTrack</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center h-screen text-white">
    <div class="text-center animate-[fadeInScale_1.5s_ease-out]">
        <h1 class="text-4xl md:text-6xl font-bold tracking-wide mb-4">Welcome to</h1>
        <h2 class="text-5xl md:text-7xl font-extrabold text-yellow-300 drop-shadow-md">MyGlucoTrack</h2>
        <p class="mt-4 text-md text-gray-300 opacity-80">
        <p class="mt-4 text-md text-gray-300 opacity-80">
    <span id="dev-name" class="font-bold text-yellow-300"></span>
</p>
</p>



<script>
const name = "Developed by Heviinash Parugavelu";
let i = 0;
const span = document.getElementById("dev-name");

function typeWriter() {
    if (i < name.length) {
        span.innerHTML += name.charAt(i);
        i++;
        setTimeout(typeWriter, 100);
    }
}

typeWriter();
</script>



    </div>

    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = 'auth/login.php';
        }, 5000);
    </script>
</body>
</html>
