<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">{{ __('Pilih posisi pemilihan') }}</h2>
    </x-slot>

    <div>
        <div>
            <div>
                @if (session('success'))
                    <div>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <p>Silahkan pilih posisi pemilihan yang ingin Anda pilih:</p>

                <div>
                    <a href="{{ route('vote.osis') }}"
                       @if($user->has_voted_osis) onclick="return false;" @endif>
                        {{ __('Pilih Ketua OSIS') }}
                        @if($user->has_voted_osis) (Sudah Memilih) @endif
                    </a>

                    <a href="{{ route('vote.mpk') }}"
                        @if($user->has_voted_mpk) onclick="return false;" @endif>
                        {{ __('Pilih Ketua MPK') }}
                        @if($user->has_voted_mpk) (Sudah Memilih) @endif
                    </a>
                </div>

                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>