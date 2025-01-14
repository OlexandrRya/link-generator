<!DOCTYPE html>
<html>
<head>
    <title>Welcome {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-2xl mx-auto space-y-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Welcome, {{ $user->name }}!</h2>
            <span class="text-sm text-gray-600">Expires: {{ $link->expired_date->format('Y-m-d H:i:s') }}</span>
        </div>

        <div class="flex space-x-4 mb-8">
            <form action="{{ route('links.regenerate', $link->uid) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Generate New Link
                </button>
            </form>

            <form action="{{ route('links.deactivate', $link->uid) }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to deactivate this link?')">
                    Deactivate Link
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <button id="playButton" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-lg">
                I'm Feeling Lucky
            </button>

            <button id="historyButton" class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded text-lg">
                History
            </button>

            <div id="gameResult" class="hidden bg-gray-100 p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Game Result</h3>
                <div id="gameResultContent"></div>
            </div>

            <div id="gameHistory" class="hidden bg-gray-100 p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Last 3 Games</h3>
                <div id="gameHistoryContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const uid = '{{ $link->uid }}';

    document.getElementById('playButton').addEventListener('click', async () => {
        try {
            const response = await axios.post(`/api/games/${uid}/play`);
            const result = response.data;

            const resultHtml = `
                    <div class="space-y-2">
                        <p>Number: <span class="font-bold">${result.random_number}</span></p>
                        <p>Result: <span class="font-bold ${result.result === 'Win' ? 'text-green-600' : 'text-red-600'}">${result.result}</span></p>
                        <p>Win Amount: <span class="font-bold">$${result.win_amount}</span></p>
                    </div>
                `;

            document.getElementById('gameResultContent').innerHTML = resultHtml;
            document.getElementById('gameResult').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
        }
    });

    document.getElementById('historyButton').addEventListener('click', async () => {
        try {
            const response = await axios.get(`/api/games/${uid}/history`);
            const history = response.data;

            const historyHtml = history.length ? history.map(game => `
                    <div class="border-b border-gray-200 py-2 last:border-0">
                        <p>Number: <span class="font-bold">${game.random_number}</span></p>
                        <p>Result: <span class="font-bold ${game.is_win ? 'text-green-600' : 'text-red-600'}">${game.is_win ? 'Win' : 'Lose'}</span></p>
                        <p>Win Amount: <span class="font-bold">$${game.win_amount}</span></p>
                        <p class="text-sm text-gray-600">${new Date(game.created_at).toLocaleString()}</p>
                    </div>
                `).join('') : '<p>No game history yet</p>';

            document.getElementById('gameHistoryContent').innerHTML = historyHtml;
            document.getElementById('gameHistory').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
</body>
</html>