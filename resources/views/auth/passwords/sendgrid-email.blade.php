<!-- resources/views/send_email.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>

    <h1>Send Email with Template</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form action="{{ route('send.email') }}" method="get">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <button type="submit">Send Email</button>
    </form>

    <h2>Test Email</h2>
    <a href="{{ route('send.test.email') }}">Send Test Email</a>

</body>
</html>
