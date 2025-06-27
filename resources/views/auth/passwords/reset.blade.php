<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
  </head>
  <body class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/image/slide_1.jpeg') }}');">
    <div class="bg-white bg-opacity-15 p-8 rounded-lg shadow-lg text-center w-full max-w-md">
      <img alt="Logo" class="w-24 h-24 rounded-full mx-auto mb-4" src="{{ asset('assets/image/logowba.png') }}" width="100" height="100"/>
      <h2 class="text-white text-2xl font-semibold mb-6">Reset Password</h2>

      @if (session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
          {{ session('status') }}
        </div>
      @endif

      <form action="{{ route('reset.password') }}" method="POST">
        @csrf <!-- Laravel CSRF Protection -->
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
          <input
            id="email"
            name="email"
            type="email"
            placeholder="Email Address"
            class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') is-invalid @enderror"
            value="{{ old('email', $email) }}"
            required
            autocomplete="email"
          />
          @error('email')
            <span class="text-red-500 text-sm mt-2 block">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-4">
          <input
            id="password"
            name="password"
            type="password"
            placeholder="New Password"
            class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') is-invalid @enderror"
            required
            autocomplete="new-password"
          />
          @error('password')
            <span class="text-red-500 text-sm mt-2 block">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-6">
          <input
            id="password-confirm"
            name="password_confirmation"
            type="password"
            placeholder="Confirm Password"
            class="w-full p-3 rounded-full bg-white bg-opacity-75 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            autocomplete="new-password"
          />
        </div>

        <button
          type="submit"
          class="w-full p-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800"
        >
          Reset Password
        </button>
      </form>

      <a href="{{ route('login') }}" class="block mt-4 text-white text-sm">
        Back to Login
      </a>
    </div>
  </body>
</html>
