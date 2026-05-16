<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $config['title'] }} – {{ $config['org_name'] }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f8; color: #212529; min-height: 100vh; }

        .nf-header {
            background: #0b1437;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nf-logo {
            width: 32px; height: 32px;
            background: #1a3a6b;
            border: 2px solid #4d7efa;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 0.9rem;
        }
        .nf-brand { color: #fff; font-weight: 700; font-size: 1rem; }

        .page-wrap {
            max-width: 540px;
            margin: 40px auto;
            padding: 0 20px 60px;
        }

        @media (max-width: 600px) {
            .page-wrap { margin: 20px auto; }
        }

        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e9ebec;
            overflow: hidden;
        }
        .card-header {
            padding: 28px 32px 20px;
            border-bottom: 1px solid #f0f0f5;
        }
        .card-header h1 { font-size: 1.375rem; font-weight: 700; color: #212529; margin-bottom: 8px; }
        .card-header p  { font-size: 0.875rem; color: #6c757d; line-height: 1.6; }
        .card-body { padding: 28px 32px; display: flex; flex-direction: column; gap: 24px; }

        /* Amount presets */
        .preset-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        @media (max-width: 480px) { .preset-grid { grid-template-columns: repeat(2, 1fr); } }

        .preset-btn {
            padding: 12px 8px;
            border: 2px solid #e9ebec;
            border-radius: 10px;
            background: #fff;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            text-align: center;
            transition: all .15s;
        }
        .preset-btn:hover { border-color: #405189; color: #405189; background: #f0f4ff; }
        .preset-btn.active { border-color: #405189; background: #405189; color: #fff; }

        .custom-row { display: flex; gap: 10px; }
        .custom-row input {
            flex: 1;
            padding: 11px 14px;
            border: 2px solid #e9ebec;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            color: #212529;
            outline: none;
            transition: border-color .15s;
        }
        .custom-row input:focus { border-color: #405189; }
        .currency-select {
            padding: 11px 14px;
            border: 2px solid #e9ebec;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #495057;
            background: #fff;
            cursor: pointer;
        }

        label.field-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        input.text-input, textarea.text-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e9ebec;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #212529;
            font-family: inherit;
            outline: none;
            transition: border-color .15s;
        }
        input.text-input:focus, textarea.text-input:focus { border-color: #405189; }

        .toggle-row {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        .toggle-row input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: #405189;
            cursor: pointer;
        }
        .toggle-row span { font-size: 0.875rem; color: #495057; }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: #405189;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }
        .submit-btn:hover { background: #354475; }
        .submit-btn:disabled { background: #adb5bd; cursor: not-allowed; }

        .error-alert {
            background: #fff5f5;
            border: 1px solid #ffd0d0;
            border-radius: 10px;
            padding: 14px 18px;
            color: #c53030;
            font-size: 0.875rem;
        }

        .divider { border: none; border-top: 1px solid #f0f0f5; }

        .section-title { font-size: 0.8125rem; font-weight: 600; color: #343a40; }

        .amount-display {
            text-align: center;
            padding: 16px;
            background: #f8f9ff;
            border-radius: 10px;
            border: 1px solid #e5eaff;
        }
        .amount-display .lbl { font-size: 0.75rem; color: #8ba3d4; margin-bottom: 4px; }
        .amount-display .val { font-size: 1.75rem; font-weight: 800; color: #405189; }
    </style>
</head>
<body>

<div class="nf-header">
    <div class="nf-logo">N</div>
    <span class="nf-brand">{{ $config['org_name'] }}</span>
</div>

<div class="page-wrap">

    @if(session('payment_error'))
        <div class="error-alert" style="margin-bottom:16px">{{ session('payment_error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h1>{{ $config['title'] }}</h1>
            @if($config['description'])
                <p>{{ $config['description'] }}</p>
            @endif
        </div>

        <form method="POST" action="{{ route('donate.submit') }}" id="donate-form">
            @csrf

            <div class="card-body">

                {{-- Összeg --}}
                <div>
                    <p class="section-title" style="margin-bottom:12px">{{ __('donations.amount_label') }}</p>

                    @if($config['presets'])
                    <div class="preset-grid" style="margin-bottom:12px">
                        @foreach($config['presets'] as $preset)
                            <button type="button" class="preset-btn" onclick="selectPreset({{ $preset }})">
                                {{ number_format($preset, 0, ',', ' ') }}
                            </button>
                        @endforeach
                    </div>
                    @endif

                    <div class="custom-row">
                        <input type="number" name="amount" id="amount-input"
                               min="100" step="1"
                               value="{{ old('amount', $config['presets'][0] ?? 1000) }}"
                               placeholder="{{ __('donations.amount_placeholder') }}"
                               oninput="onCustomInput()"
                               required>
                        <select name="currency" class="currency-select">
                            <option value="HUF" {{ $config['currency'] === 'HUF' ? 'selected' : '' }}>HUF</option>
                            <option value="EUR" {{ $config['currency'] === 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="USD" {{ $config['currency'] === 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                    </div>

                    @error('amount')
                        <p style="color:#c53030;font-size:0.8rem;margin-top:6px">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="divider">

                {{-- Adatok --}}
                <div style="display:flex;flex-direction:column;gap:16px">
                    <p class="section-title">{{ __('donations.your_info') }}</p>

                    <div>
                        <label class="field-label" for="name">{{ __('donations.name_label') }}</label>
                        <input type="text" id="name" name="name" class="text-input"
                               value="{{ old('name') }}"
                               placeholder="{{ __('donations.name_placeholder') }}">
                    </div>
                    <div>
                        <label class="field-label" for="email">{{ __('donations.email_label') }}</label>
                        <input type="email" id="email" name="email" class="text-input"
                               value="{{ old('email') }}"
                               placeholder="{{ __('donations.email_placeholder') }}">
                        <p style="font-size:0.75rem;color:#adb5bd;margin-top:4px">{{ __('donations.email_hint') }}</p>
                    </div>
                    <div>
                        <label class="field-label" for="message">{{ __('donations.message_label') }}</label>
                        <textarea id="message" name="message" class="text-input" rows="3"
                                  placeholder="{{ __('donations.message_placeholder') }}">{{ old('message') }}</textarea>
                    </div>
                    <label class="toggle-row">
                        <input type="checkbox" name="anonymous" value="1" {{ old('anonymous') ? 'checked' : '' }}>
                        <span>{{ __('donations.anonymous_label') }}</span>
                    </label>
                </div>

                <hr class="divider">

                {{-- Összesítő --}}
                <div class="amount-display">
                    <div class="lbl">{{ __('donations.total_label') }}</div>
                    <div class="val" id="total-display">
                        {{ number_format(old('amount', $config['presets'][0] ?? 1000), 0, ',', ' ') }} {{ $config['currency'] }}
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submit-btn">
                    {{ __('donations.submit') }}
                </button>

                <p style="text-align:center;font-size:0.75rem;color:#adb5bd">
                    {{ __('donations.secure_hint') }}
                </p>

            </div>
        </form>
    </div>

</div>

<script>
const presets = @json($config['presets']);
const currency = @json($config['currency']);

function selectPreset(val) {
    document.getElementById('amount-input').value = val;
    updatePresetButtons(val);
    updateTotal();
}

function onCustomInput() {
    const val = parseInt(document.getElementById('amount-input').value) || 0;
    updatePresetButtons(presets.includes(val) ? val : null);
    updateTotal();
}

function updatePresetButtons(active) {
    document.querySelectorAll('.preset-btn').forEach(btn => {
        const v = parseInt(btn.textContent.replace(/\s/g, ''));
        btn.classList.toggle('active', v === active);
    });
}

function updateTotal() {
    const val  = parseInt(document.getElementById('amount-input').value) || 0;
    const curr = document.querySelector('[name="currency"]').value;
    document.getElementById('total-display').textContent =
        val.toLocaleString('hu-HU') + ' ' + curr;
}

document.querySelector('[name="currency"]').addEventListener('change', updateTotal);

// Init
selectPreset(parseInt(document.getElementById('amount-input').value) || presets[0] || 1000);
</script>

</body>
</html>
