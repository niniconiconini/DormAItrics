<x-layout>
    <x-slot:title>facial-recognition</x-slot:title>    
    <section class="facial-recognition">
        <header class="page-title">Please input your Email to manually log your time out / time in</header>
        <div>
            <form action="{{ route('facial-recognition.manual') }}" method="POST">
            @csrf
                <label for="manualEntry">Email:</label>
                <input type="email" id="manualEntry" name="manualEntry" required>
                <div class="form-buttons"><button type="submit" class="btn-primary">Find Me</button></div>
            </form>
        </div>
        <br>
        <div class="entry">
            <header class="page-title">Automatically log your time out / time in</header>
            <a id="scan-button" class="btn-primary scan" href="{{ route('facial-recognition.scan') }}" style="text-decoration: none;">Scan Me</a>
        </div>

        {{-- modal pop out for user verification --}}
        @if(session('confirmIdentity') && session('recognized_resident_name') && !session('message'))
            <div class="modal">
                <div class="card scan-modal">
                    <p>Hello! Are you<br><strong>{{ session('recognized_resident_name') }}</strong>?</p>
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
        {{-- modal pop out for pass slip checking --}}
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
        {{-- modal pop out notes if no pass slip --}}
        @if(session('overridePassSlip'))
            <div class="modal">
                <div class="card scan-modal" style="height:50%;">
                     <label>This resident does not have an available pass slip for the current departure time.</label>
                     <div class="time-details" style="padding-top: 1rem;">
                        <div><strong>Requested Time Out: </strong>{{ session('requestedTimeOut') }}</div>
                        <div><strong>Current Time: </strong>{{ now()->format('h:i A') }}</div>
                    </div>
                    <div class="modal-actions" style="padding-top: 1rem;">
                        <form method="POST" action="{{ route('facial-recognition.no-slip') }}">
                        @csrf
                        <label>Please provide a reason if you will be allowing this resident to leave without an approved pass slip.</label>
                        <textarea name="notes" required></textarea>
                        <div class="modal-actions">
                            <button type="submit" class="btn-primary">Log Time Out</button>
                            <a href="{{ route('facial-recognition') }}" class="btn-primary">Close</a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>