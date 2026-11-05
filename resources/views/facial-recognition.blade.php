<x-layout>
    <x-slot:title>facial-recognition</x-slot:title>    
    <header class="page-title">FACIAL RECOGNITION SCANNER</header>
    <section class="facial-recognition">
        <div class="entry">
            <a class="btn-primary scan" href="{{ route('facial-recognition.scan') }}" style="text-decoration: none;">Scan Me</a>
        </div>
        <div>
            @if (session('scan_attempts', 0) >= 3)
                <form action="{{ route('facial-recognition.manual') }}" method="POST">
                @csrf
                    <label for="manualEntry">Email:</label>
                    <input type="text" id="manualEntry" name="manualEntry" required>
                    <div class="form-buttons"><button type="submit" class="btn-primary">CONTINUE</button></div>
                </form>
            @endif
        </div>

        @if(session('confirmIdentity') && session('recognized_resident_name') && !session('message'))
            <div class="modal">
                <div class="card scan-modal">
                    <p>Hello! Are you {{ session('recognized_resident_name') }}?</p>
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
                <div class="card scan-modal">
                    <p>{{ session('message') }}</p>
                    <div class="form-buttons">
                        <button class="btn-primary" style="align-items:center; font-size: 2rem;" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>