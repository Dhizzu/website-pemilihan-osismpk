<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Pilih CalonKetua MPK') }}</h2>
    </x-slot>

    <div>
        <div>
            <div>
                @if (session('error'))
                    <div>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($user->has_voted_mpk)
                    <p>Anda sudah memilih Calon Ketua MPK, Anda tidak bisa memilih lagi</p>
                    <div>
                        <a href="{{ route('vote.selection') }}">Kembali ke Pilihan</a>
                    </div>
                @else
                    <p>Klik pada foto atau nama untuk memilih</p>
                    <div>
                        @foreach ($candidates as $candidate)
                            <div>
                                <form id="vote-form-{{ $candidate->id }}" action="{{ route('vote.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                    <input type="hidden" name="position" value="mpk">

                                    <div onclick="if(confirm('Anda yakin memilih {{ $candidate->name }} sebagai Ketua MPK?')) { document.getElementById('vote-form-{{ $candidate->id }}').submit(); }">
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}">
                                        @else
                                            <div>
                                                No Photo
                                            </div>
                                        @endif
                                        <h3>{{ $candidate->name }}</h3>
                                        <p>{{ $candidate->description }}</p>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>