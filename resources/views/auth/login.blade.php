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
    <div class="bg-gray-700 bg-opacity-50 p-8 rounded-lg shadow-lg text-center w-full max-w-sm">
      <img alt="Logo" class="w-24 h-24 rounded-full mx-auto mb-4" src="{{ asset('assets/image/logowba.png') }}" width="100" height="100"/>
      <h2 class="text-white text-2xl font-semibold mb-6">SELAMAT DATANG</h2>
      <form action="{{ route('login') }}" method="POST">
        @csrf <!-- Laravel CSRF Protection -->

        <div class="mb-4">
          <input
            id="email"
            name="email"
            type="email"
            placeholder="Email"
            class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            required
            autocomplete="email"
            autofocus
          />
          @error('email')
            <span class="text-red-500 text-sm mt-2 block">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-6">
          <input
            id="password"
            name="password"
            type="password"
            placeholder="Password"
            class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') is-invalid @enderror"
            required
            autocomplete="current-password"
          />
          @error('password')
            <span class="text-red-500 text-sm mt-2 block">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="flex items-center mb-4">
          <input
            type="checkbox"
            name="remember"
            id="remember"
            class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            {{ old('remember') ? 'checked' : '' }}
          />
          <label for="remember" class="text-white text-sm">Remember Me</label>
        </div>

        <button
          type="submit"
          class="w-full p-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800"
        >
          Login
        </button>

        @if (Route::has('forgot.password.form'))
  <a class="block mt-4 text-white text-sm" href="{{ route('forgot.password.form') }}">
    Forgot Username / Password?
  </a>
@endif

      </form>


    </div>
  </body>
</html>
