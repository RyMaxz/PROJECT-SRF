@if (request()->routeIs('filament.*.auth.*'))
    <img src="{{ asset('images/logo-itb.png') }}" alt="Logo ITB" style="height: 100%; object-fit: contain;">
@else
    <div style="display: flex; align-items: center; gap: 12px; height: 100%;">
        <img src="{{ asset('images/logo-itb.png') }}" alt="Logo ITB" style="height: 100%; object-fit: contain;">
        
        <span style="font-size: 22px; font-weight: 800; line-height: 1; letter-spacing: 0.5px;">
            <bold><i>PROJECT:SRF</i></bold>
        </span>
    </div>
@endif