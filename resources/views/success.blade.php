<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
    <h2 class="text-2xl font-bold mb-4 text-green-600">{{ $success_text }}</h2>
    <p class="mb-4">Your unique access link ( expires {{$expired_date}} ):</p>
    <div class="bg-gray-100 p-4 rounded break-all">
        <a href="{{ $access_url }}" class="text-blue-600 hover:text-blue-800">{{ $access_url }}</a>
    </div>
</div>
</body>
</html>