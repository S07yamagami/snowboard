<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1529669851596-ba9a5549af95?q=80&w=3132&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-white text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">雪上で最高の自分へ。</h1>
            <p class="max-w-2xl text-lg md:text-xl mb-4">
                Salomonは、革新的なギアであなたの可能性を解き放ちます。<br>
                限界を超え、新たな自分へ。<br>
                情熱をともにする”仲間”と、忘れられない瞬間を。
            </p>
            <button class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-6 rounded-lg text-lg">
                ホームページについて
            </button>
        </div>
    </div>
</x-app-layout>
