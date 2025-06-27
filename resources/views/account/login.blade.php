<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
  </head>
  <body class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/image/slide_1.jpeg') }}');">
    <div class="bg-white bg-opacity-15 p-8 rounded-lg shadow-lg text-center w-full max-w-sm">
      <img alt="Profile picture of John Doe" class="w-24 h-24 rounded-full mx-auto mb-4" height="100" src="{{ asset('assets/image/logowba.png') }}" width="100"/>
      <h2 class="text-white text-2xl font-semibold mb-6">SELAMAT DATANG</h2>
      <form action="{{ route('login') }}" method="POST">
        @csrf <!-- Laravel CSRF Protection -->
        <div class="mb-4">
          <input class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" placeholder="Email" type="text" required/>
        </div>
        <div class="mb-6">
          <input class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password" placeholder="Password" type="password" required/>
        </div>
        <button class="w-full p-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800" type="submit">Login</button>
      </form>
      <a class="block mt-4 text-white text-sm" href="#">Forgot Username / Password?</a>
    </div>
  </body>
</html>
