<x-layout>
    <x-slot:title>facial-recognition</x-slot:title>    
    <header class="page-title">FACIAL RECOGNITION SCANNER</header>
    <section class="facial-recognition">
        <a class="btn-primary scan" href="{{ route('facial-recognition.scan') }}" style="text-decoration: none;">Scan Me</a>
        @if(isset($confirmIdentity))
            <div class="modal">
                <div class="card user-modal">
                    <h2>Hello, {{ $resident->user->nickname }}!</h2>
                    <p>Is this you?</p>
                    <div class="form-buttons">
                        <form action="{{ route('facial-recognition.confirm') }}" method="POST">
                        @csrf
                            <button type="submit" class="btn-primary">YES</button>
                        </form>
                        <form action="{{ route('facial-recognition.reject') }}" method="POST">
                        @csrf
                            <button type="submit" class="btn-primary">NO</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if(session('message'))
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <p style="text-align: center; font-weight: bold;">{{ session('message') }}</p>
                    <div class="form-buttons">
                        <button class="btn-primary" style="align-items:center; font-size: 2rem;" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>